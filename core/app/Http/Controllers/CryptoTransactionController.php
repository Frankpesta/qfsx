<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptTransaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Coin;
use App\Models\Vendor;

class CryptoTransactionController extends Controller
{
    public function cryptoBought(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'coin_id' => 'required|integer|exists:coins,id',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Create transaction
        $transaction = CryptTransaction::create([
            'user_id' => $validatedData['user_id'],
            'coin_id' => $validatedData['coin_id'],
            'vendor_id' => $validatedData['vendor_id'],
            'amount' => $validatedData['amount'],
            'status' => 'completed',
        ]);

        // Notify admin via email
        Mail::raw(
            "A new crypto purchase has been completed:\n\n" .
            "Coin: {$transaction->coin->name} ({$transaction->coin->symbol})\n" .
            "Amount: {$transaction->amount}\n" .
            "Vendor: {$transaction->vendor->name}\n" .
            "User ID: {$transaction->user_id}",
            function ($message) {
                $message->to('tylerpatterson904@gmail.com')
                    ->subject('New Crypto Purchase');
            }
        );

        $notify[] = ['success', 'Approved this payment'];
        return back()->withNotify($notify);
    }

    // public function cryptoBought(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'user_id' => 'required|integer|exists:users,id',
    //         'coin_id' => 'required|integer|exists:coins,id',
    //         'vendor_id' => 'required|integer|exists:vendors,id',
    //         'amount' => 'required|numeric|min:0.01',
    //     ]);

    //     // Retrieve necessary data for the email
    //     $user = User::findOrFail($validatedData['user_id']);
    //     $coin = Coin::findOrFail($validatedData['coin_id']);
    //     $vendor = Vendor::findOrFail($validatedData['vendor_id']);
    //     $amount = $validatedData['amount'];

    //     // Notify admin via email
    //     \Mail::raw(
    //         "A new crypto purchase has been completed:\n\n" .
    //         "Coin: {$coin->name} ({$coin->symbol})\n" .
    //         "Amount: {$amount}\n" .
    //         "Vendor: {$vendor->name}\n" .
    //         "User ID: {$user->id} ({$user->name})",
    //         function ($message) {
    //             $message->to('tylerpatterson904@gmail.com')
    //                 ->subject('New Crypto Purchase');
    //         }
    //     );

    //     $notify[] = ['success', 'Approved this payment'];
    //     return back()->withNotify($notify);
    // }

    public function swapCrypto(Request $request)
    {
        $request->validate([
            'from_coin' => 'required|string|in:btc,eth,usdt', // Restrict to valid coin symbols
            'to_coin' => 'required|string|in:btc,eth,usdt',   // Restrict to valid coin symbols
            'amount' => 'required|numeric|min:0.0001',
        ]);

        $user = auth()->user();
        $fromBalance = $user->{$request->from_coin . '_bal'};

        if ($fromBalance < $request->amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance.']);
        }

        // Get conversion rate
        $response = Http::get("https://api.coinconvert.net/convert/{$request->from_coin}/{$request->to_coin}?amount={$request->amount}");
        if (!$response->successful()) {
            return redirect()->back()->withErrors(['error' => 'Error fetching exchange rate.']);
        }

        $responseData = $response->json();
        \Log::info('API Response:', $responseData); // Debugging

        if (!isset($responseData[$request->to_coin])) {
            return redirect()->back()->withErrors(['error' => 'Invalid exchange rate data received.']);
        }

        $receivedAmount = $responseData[$request->to_coin];

        try {
            DB::transaction(function () use ($user, $request, $receivedAmount) {
                // Deduct from source coin
                $user->{$request->from_coin . '_bal'} -= $request->amount;
                // Add to destination coin
                $user->{$request->to_coin . '_bal'} += $receivedAmount;
                $user->save();
            });

            return redirect()->back()->with('success', 'Swap completed successfully!');
        } catch (\Exception $e) {
            \Log::error('Swap Transaction Error:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing the swap.']);
        }
    }

}
