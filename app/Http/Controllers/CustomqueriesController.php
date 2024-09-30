<?php

namespace App\Http\Controllers;

use App\Models\Customqueries;
use Illuminate\Http\Request;
use Validator;
use App\Models\Purchase;

class CustomqueriesController extends Controller
{
    public function store_customqueries(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'jewel_id' => 'required|integer|exists:jewels,id',
        'user_id' => 'required|integer|exists:users,id',
        'size' => 'required|string|max:50',
        'quantity' => 'required|integer|min:1',
        'total_price' => 'required|integer',
        'mobile_number' => 'required|string|max:15',
        'customer_name' => 'required|string|max:255',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 400);
    }

    // Fetch the latest purchase for the user and jewel
    $purchase = Purchase::where('user_id', $request->input('user_id'))
        ->where('jewel_id', $request->input('jewel_id'))
        ->latest()
        ->first();

    // Check if the purchase exists and get its status
    $status = $purchase ? $purchase->status : 'pending'; // Default to 'pending' if no purchase found

    // Create a new instance of the Customqueries model
    $storecustomquerie = new Customqueries();
    $storecustomquerie->jewel_id = $request->input('jewel_id');
    $storecustomquerie->user_id = $request->input('user_id');
    $storecustomquerie->total_price = $request->input('total_price');
    $storecustomquerie->customer_name = $request->input('customer_name');
    $storecustomquerie->mobile_number = $request->input('mobile_number');
    $storecustomquerie->size = $request->input('size');
    $storecustomquerie->quantity = $request->input('quantity');

    // Set status from the purchase
    $storecustomquerie->status = $status;

    // Save the custom query
    $storecustomquerie->save();

    // Return a success response
    return response()->json([
        'success' => true,
        'message' => 'Custom query stored successfully',
        'data' => $storecustomquerie
    ], 200);
}


}
