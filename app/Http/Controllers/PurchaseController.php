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
        // Set default payment method to 'razorpay'
        $request->merge(['payment_method' => 'razorpay']);
    
        // Validation rules
        $validator = Validator::make($request->all(), [
            'jewel_id' => 'required|integer|exists:jewels,id',
            'amount' => 'nullable|integer|exists:jewels,price',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'required|string|max:15',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:razorpay',
            'size' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'total_price' => 'required|numeric',
            'razorpay_payment_id' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);
    
        // Handle validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Create a new Purchase record
        $purchase = new Purchase();
        $purchase->jewel_id = $request->input('jewel_id');
        $purchase->amount = $request->input('amount');
        $purchase->total_price = $request->input('total_price');
        $purchase->customer_name = $request->input('customer_name');
        $purchase->size = $request->input('size');
        $purchase->quantity = $request->input('quantity');
        $purchase->email = $request->input('email');
        $purchase->mobile_number = $request->input('mobile_number');
        $purchase->zip_code = $request->input('zip_code');
        $purchase->address = $request->input('address');
        $purchase->payment_method = $request->input('payment_method');
        $purchase->user_id = $request->input('user_id');
        $purchase->razorpay_payment_id = $request->input('razorpay_payment_id');
        $purchase->status = 'success'; // Update status to success
    
        // Save the Purchase record
        $purchase->save();
    
        // Update the corresponding Customqueries record
        $customQuery = Customqueries::where('user_id', $request->input('user_id'))
            ->where('jewel_id', $request->input('jewel_id'))
            ->first();
    
        if ($customQuery) {
            $customQuery->status = 'success'; // Update the status
            $customQuery->save(); // Save the changes
        }
    
        // Return a success response with the purchase data
        return response()->json([
            'success' => true,
            'message' => 'Purchase completed successfully!',
            'data' => $purchase
        ], 200);
    }
    



    public function fetch_jewel()
    {
        $fetchjewel = Jewel::all();
        return response()->json($fetchjewel);
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






    public function getpurchase(Request $request)
{
    $fetchpurchase = Purchase::all(); // Fetch all purchases

    // Check if the request is AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Payment fetched successfully',
            'data' => $fetchpurchase
        ]);
    }

    // If not an AJAX request, return a view (if needed)
    return view('smith.payment-status', compact('fetchpurchase'));
}

}
