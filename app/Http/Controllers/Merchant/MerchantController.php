<?php

namespace App\Http\Controllers\Merchant;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantController extends Controller
{
    /**
     * Display a listing of the merchants.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all merchants from the database
        $merchants = Merchant::all();

        // Return the list of merchants as JSON
        return response()->json(['message' => 'Merchants retrieved successfully', 'data' => $merchants]);
    }
}
