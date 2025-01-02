<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;

class CoinController extends Controller
{
    public function index()
    {
        $coins = Coin::all();
        return response()->json($coins);
    }
}
