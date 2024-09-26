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


    public function storepurchasedetails(Request $request)
{
    // Validation rules with conditional checks for payment method
    $validator = Validator::make($request->all(), [
        'jewel_id' => 'required|integer|exists:jewels,id', // Ensure jewel_id exists
        'amount' => 'nullable|integer|exists:jewels,price', // Ensure valid amount
        'customer_name' => 'required|string|max:255',
        'email' => 'required|email',
        'mobile_number' => 'required|string|max:15',
        'zip_code' => 'required|string|max:10',
        'address' => 'required|string',
        'payment_method' => 'required|string|in:card,razorpay,cash_on_delivery',
        'size' => 'nullable|string|max:255', // Optional size validation
        'quantity' => 'nullable|integer|min:1', // Optional quantity validation
        'total_price' => 'required|numeric', // Ensure total_price is validated

        // Conditionally required fields for card payment method
        'card_name' => 'required_if:payment_method,card|string|max:255',
        'card_number' => 'required_if:payment_method,card|string|max:19',
        'expiry_date' => 'required_if:payment_method,card|string|max:7',
        'cvv' => 'required_if:payment_method,card|string|max:4',

        // Conditionally required field for Razorpay payment method
        'razorpay_payment_id' => 'required_if:payment_method,razorpay|string|max:255',

        'user_id' => 'required|integer|exists:users,id', // Ensure user_id exists
    ]);

    // Handle validation errors
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

    // Return a success response with the purchase data
    return response()->json([
        'sucess'=>true,
        'message' => 'Purchase completed successfully!',
        'data' => $purchase
    ], 200);
}



    public function fetch_jewel()
    {
        $fetchjewel = Jewel::all();
        return response()->json($fetchjewel);
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


    public function getcustomize()
    {
        return view('user.customize-jewel');
    }

    // In your controller
    public function purchases($id)
    {
        // Fetch the jewel by its ID
        $jewels = Jewel::findOrFail($id); // This will throw an error if not found

        // Generate the full URL for the jewel image
        $jewels->jewel_image = asset($jewels->jewel_image);

        // Check if the request expects a JSON response
        if (request()->wantsJson()) {
            // Return the jewel data with a success message as a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Jewel details retrieved successfully for purchase',
                'data' => [
                    'id' => $jewels->id,
                    'name' => $jewels->name,
                    'description' => $jewels->description,
                    'price' => $jewels->price,
                    'jewel_image' => $jewels->jewel_image,
                    'created_at' => $jewels->created_at,
                    'updated_at' => $jewels->updated_at,
                ]
            ]);
        }

        // Otherwise, return the view with jewel data
        return view('user.purchase', compact('jewels'));
    }






    public function getpurchase()
    {
        $fetchpurchase = Purchase::all();
        return view('smith.payment-status', compact('fetchpurchase'));
    }
}
