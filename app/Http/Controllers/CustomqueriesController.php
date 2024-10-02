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
    // Validate incoming request data
    $validator = Validator::make($request->all(), [
        'jewel_id' => 'required|integer|exists:jewels,id',
        'user_id' => 'required|integer|exists:users,id',
        'size' => 'required|string|max:50',
        'quantity' => 'required|integer|min:1',
        'total_price' => 'required|integer',
        'mobile_number' => 'required|string|max:15',
        'customer_name' => 'required|string|max:255',
        'razorpay_payment_id' => 'nullable|string', // Validate payment ID
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 400);
    }

    // Check if a query already exists for the given jewel_id
    $existingQuery = Customqueries::where('jewel_id', $request->input('jewel_id'))
        ->where('user_id', $request->input('user_id'))
        ->first();

    if ($existingQuery) {
        // If it exists, update the relevant fields as needed
        $existingQuery->size = $request->input('size');
        $existingQuery->quantity = $request->input('quantity');
        $existingQuery->total_price = $request->input('total_price');
        $existingQuery->mobile_number = $request->input('mobile_number');
        $existingQuery->customer_name = $request->input('customer_name');

        // Save the updated query
        $existingQuery->save();

        // Return a response indicating the update
        return response()->json([
            'success' => true,
            'message' => 'Custom query updated successfully',
            'data' => $existingQuery
        ], 200);
    } else {
        // Create a new instance of the Customqueries model
        $storecustomquerie = new Customqueries();
        $storecustomquerie->jewel_id = $request->input('jewel_id');
        $storecustomquerie->user_id = $request->input('user_id');
        $storecustomquerie->total_price = $request->input('total_price');
        $storecustomquerie->customer_name = $request->input('customer_name');
        $storecustomquerie->mobile_number = $request->input('mobile_number');
        $storecustomquerie->size = $request->input('size');
        $storecustomquerie->quantity = $request->input('quantity');

        // Set initial status to pending
        $storecustomquerie->status = 'pending';

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

    

}
