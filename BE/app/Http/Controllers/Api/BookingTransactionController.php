<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    public function index()
    {
        // $bookingTransactions = auth()->user()->bookingTransactions()->with('officeSpace.city', 'officeSpace.photos')->get();
        // return response()->json([
        //     'data' => $bookingTransactions
        // ]);
        
    }
}
