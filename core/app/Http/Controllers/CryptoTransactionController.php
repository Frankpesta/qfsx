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
            'from_coin' => 'required|string|in:xlm,xrp,algo,eth,btc', // Updated supported coins
            'to_coin' => 'required|string|in:xlm,xrp,algo,eth,btc',   // Updated supported coins
            'amount' => 'required|numeric|min:0.0001',
        ]);

        $user = auth()->user();
        $fromBalance = $user->{$request->from_coin . '_bal'};

        if ($fromBalance < $request->amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance.']);
        }

        // Get conversion rate
        try {
            $response = Http::timeout(10)->get("https://api.coinconvert.net/convert/{$request->from_coin}/{$request->to_coin}?amount={$request->amount}");

            if (!$response->successful()) {
                \Log::error('Swap API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'from' => $request->from_coin,
                    'to' => $request->to_coin,
                    'amount' => $request->amount
                ]);
                return redirect()->back()->withErrors(['error' => 'Error fetching exchange rate.']);
            }

            $responseData = $response->json();
            \Log::info('Swap API Response:', $responseData);

            $toCoinUpper = strtoupper($request->to_coin);
            if (!isset($responseData[$toCoinUpper])) {
                \Log::error('Invalid API Response:', $responseData);
                return redirect()->back()->withErrors(['error' => 'Invalid exchange rate data received.']);
            }

            $receivedAmount = $responseData[$toCoinUpper];

            DB::transaction(function () use ($user, $request, $receivedAmount) {
                // Deduct from source coin
                $fromBalField = $request->from_coin . '_bal';
                $toBalField = $request->to_coin . '_bal';

                $user->$fromBalField -= $request->amount;
                $user->$toBalField += $receivedAmount;

                // Add additional validation to prevent negative balances
                if ($user->$fromBalField < 0 || $user->$toBalField < 0) {
                    throw new \Exception('Invalid balance after swap calculation.');
                }

                $user->save();

                // Optionally log the swap transaction
                \Log::info('Swap Completed:', [
                    'user' => $user->id,
                    'from_coin' => $request->from_coin,
                    'to_coin' => $request->to_coin,
                    'amount_sent' => $request->amount,
                    'amount_received' => $receivedAmount
                ]);
            });
            $notify[] = ['success', 'Swap successful!'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            \Log::error('Swap Transaction Error:', [
                'error' => $e->getMessage(),
                'user' => $user->id,
                'from_coin' => $request->from_coin,
                'to_coin' => $request->to_coin
            ]);
            $notify[] = ['error', 'An error occurred while processing the swap.'];
            return back()->withNotify($notify);
        }
    }

}
