<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JewelQuery;

class JewelQueryController extends Controller
{
    public function submitQuery(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'query_name' => 'required|string|max:255',
            'query_email' => 'required|email|max:255',
            'query_message' => 'required|string',

        ]);

        // Create a new JewelQuery instance and save it to the database
        $query = new JewelQuery();
        $query->jewel_id = $id; // Jewel ID from the route parameter
        $query->user_id = auth()->id(); // Authenticated user's ID
        $query->name = $validated['query_name'];
        $query->email = $validated['query_email'];
        $query->message = $validated['query_message'];
        $query->save();


        // Redirect the user back with a success message
        return redirect()->back()->with('success', 'Your query has been submitted successfully!');
    }

    public function submit_Query(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'jewel_id' => 'required|exists:jewels,id', // Make sure jewel_id exists
            'query_name' => 'required|string|max:255',
            'query_email' => 'required|email|max:255',
            'query_message' => 'required|string',
        ]);
    
        // Create a new JewelQuery instance
        $jewelQuery = new JewelQuery();
        $jewelQuery->jewel_id = $request->input('jewel_id');
        $jewelQuery->user_id = $id; // Assuming this is the user id
        $jewelQuery->name = $request->input('query_name');
        $jewelQuery->email = $request->input('query_email');
        $jewelQuery->message = $request->input('query_message');
    
        // Save the query
        $jewelQuery->save();
        
        // Return a response or redirect
        return response()->json(['sucess'=>true,'message' => 'Query submitted successfully!','data'=>$jewelQuery]);
    }
    
}
