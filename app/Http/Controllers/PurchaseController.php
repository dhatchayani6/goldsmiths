<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Jewel;


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
        $request->validate([
            'jewel_id' => 'required|exists:jewels,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:20',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,paypal,credit_card',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,completed,failed',
        ]);

        $purchase = Purchase::create($request->all());

        return redirect()->back()->with('success', 'Purchase recorded successfully!');
    }

    public function fetch_jewel()
    {
        $fetchjewel = Jewel::all();
        return response()->json($fetchjewel);
    }

    public function order(){
        
    }
}
