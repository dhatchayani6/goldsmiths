<?php

namespace App\Http\Controllers;

use App\Models\Customqueries;
use Illuminate\Http\Request;
use Validator;

class CustomqueriesController extends Controller
{
    public function store_customqueries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jewel_id' => 'required|integer|exists:jewels,id', // Ensure jewel_id exists
            'user_id' => 'required|integer|exists:users,id', // Ensure user_id exists
            'amount' => 'required|integer', // If you want to keep this, ensure you pass it correctly from the form


        ]);
        $storecustomquerie = new Customqueries();
        $storecustomquerie->jewel_id = $request->input('jewel_id');
        $storecustomquerie->amount = $request->input('amount'); // Store the amount
        $storecustomquerie->total_price = $request->input('total_price'); // Store the total price
        $storecustomquerie->customer_name = $request->input('customer_name');
        $storecustomquerie->save();
        return response()->json(['success'=>true,'message' => 'Custom query stored successfully','data'=>$storecustomquerie], 200);

    }
}
