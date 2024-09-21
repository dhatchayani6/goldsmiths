<?php

namespace App\Http\Controllers;

use App\Models\Customqueries;
use Illuminate\Http\Request;
use Validator;

class CustomqueriesController extends Controller
{
    public function store_customqueries(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'jewel_id' => 'required|integer|exists:jewels,id', // Ensure jewel_id exists
        'user_id' => 'required|integer|exists:users,id', // Ensure user_id exists
        'size' => 'required|string|max:50', // Validate size
        'quantity' => 'required|integer|min:1', // Validate quantity
        'total_price' => 'required|integer', // Ensure total price is provided
        'mobile_number' => 'required|string|max:15', // Validate mobile number
        'customer_name' => 'required|string|max:255', // Validate customer name
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 400);
    }

    // Create a new instance of the Customqueries model
    $storecustomquerie = new Customqueries();
    $storecustomquerie->jewel_id = $request->input('jewel_id');
    $storecustomquerie->user_id = $request->input('user_id'); // Store the user_id
    $storecustomquerie->total_price = $request->input('total_price'); // Store the total price
    $storecustomquerie->customer_name = $request->input('customer_name'); // Store the customer name
    $storecustomquerie->mobile_number = $request->input('mobile_number'); // Store the mobile number
    $storecustomquerie->size = $request->input('size'); // Store the size
    $storecustomquerie->quantity = $request->input('quantity'); // Store the quantity
    $storecustomquerie->save(); // Save the custom query

    // Return a success response
    return response()->json([
        'success' => true,
        'message' => 'Custom query stored successfully',
        'data' => $storecustomquerie
    ], 200);
}

}
