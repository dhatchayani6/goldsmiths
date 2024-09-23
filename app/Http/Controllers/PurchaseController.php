<?php

namespace App\Http\Controllers;

use App\Models\UserQueries;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Jewel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Models\Customqueries;


class PurchaseController extends Controller
{
    public function show_purchase($id)
    {
        // Fetch the jewel data based on its ID
        $fetchjewel = Jewel::find($id); // Or use where clause if needed

        // Check if jewel exists
        if (!$fetchjewel) {
            return redirect()->back()->with('error', 'Jewel not found.');
        }

        // Pass the $fetchjewel data to the view
        return view('user.purchase', compact('fetchjewel'));
    }

    public function storepurchasedetails(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'jewel_id' => 'required|integer|exists:jewels,id', // Ensure jewel_id exists
            'amount' => 'nullable|integer|exists:jewels,price', // If you want to keep this, ensure you pass it correctly from the form
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'required|string|max:15',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:card,razorpay,cash_on_delivery',
            'size' => 'nullable|string|max:255', // Add size validation
            'quantity' => 'nullable|integer|min:1', // Add quantity validation
            'total_price' => 'required|', // Ensure total_price is validated
            'card_name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:19',
            'expiry_date' => 'nullable|string|max:7',
            'cvv' => 'nullable|string|max:4',
            'razorpay_payment_id' => 'nullable|string|max:255',
            'user_id' => 'required|integer|exists:users,id', // Ensure user_id exists
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new Purchase record
        $purchase = new Purchase();
        $purchase->jewel_id = $request->input('jewel_id');
        $purchase->amount = $request->input('amount'); // Store the amount
        $purchase->total_price = $request->input('total_price'); // Store the total price
        $purchase->customer_name = $request->input('customer_name');
        
        // Capture size and quantity
        $purchase->size = $request->input('size'); // Save size
        $purchase->quantity = $request->input('quantity'); // Save quantity
        
        $purchase->email = $request->input('email');
        $purchase->mobile_number = $request->input('mobile_number');
        $purchase->zip_code = $request->input('zip_code');
        $purchase->address = $request->input('address');
        $purchase->payment_method = $request->input('payment_method');
        $purchase->user_id = $request->input('user_id'); // Store user ID

        // Handle additional fields based on payment method
        if ($request->input('payment_method') == 'card') {
            $purchase->card_name = $request->input('card_name');
            $purchase->card_number = $request->input('card_number');
            $purchase->expiry_date = $request->input('expiry_date');
            $purchase->cvv = $request->input('cvv');
        }

        if ($request->input('payment_method') == 'razorpay') {
            $purchase->razorpay_payment_id = $request->input('razorpay_payment_id');
        }

        // Save the Purchase record
        $purchase->save();

        // Return a success response
        return response()->json(['message' => 'Purchase completed successfully!'], 200);
    }
    
    public function fetch_jewel()
    {
        $fetchjewel = Jewel::all();
        return response()->json($fetchjewel);
    }

    public function getpurchase(){
        $fetchpurchase = Purchase::all();
        return view('smith.payment-status',compact('fetchpurchase')); 
    }
    public function updateStatus(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'status' => 'required|in:pending,complete,failed',
        'id' => 'required|integer|exists:purchases,id'
    ]);

    // Find the purchase by ID
    $purchase = Purchase::find($request->input('id'));

    if ($purchase) {
        // Update the status in the purchases table
        $purchase->status = $request->input('status');
        $purchase->save();

        // Update the status in the custom queries table based on jewel_id and user_id
        Customqueries::where('jewel_id', $purchase->jewel_id)
            ->where('user_id', $purchase->user_id)
            ->update(['status' => $purchase->status]);

        return response()->json(['message' => 'Status updated successfully!']);
    }

    return response()->json(['message' => 'Purchase not found.'], 404);
}


    public function getcustomize(){
        return view('user.customize-jewel');
    }

    public function purchases(){
        $purchases=Purchase::all();
        return view('smith.payment-status',compact('purchases'));
    }
   
}
