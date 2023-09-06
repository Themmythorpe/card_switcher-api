<?php

namespace App\Http\Controllers\Card;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'card_number' => 'required|unique:cards',
            'expiration' => 'required',
            'cvv' => 'required',
        ]);

        $card = Card::create([
            'card_number' => $request->input('card_number'),
            'expiration' => $request->input('expiration'),
            'cvv' => $request->input('cvv'),
        ]);

        return response()->json(['message' => 'Card created successfully', 'data' => $card]);
    }
}
