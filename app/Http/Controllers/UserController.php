<?php

namespace App\Http\Controllers;

use App;
use App\Models\Customqueries;
use App\Models\JewelQuery;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Jewel;
use Auth;



class UserController extends Controller
{
    public function fetch_jewels()
    {
        try {
            // Fetch all jewels from the database
            $jewels = Jewel::all();

            // Return JSON response with success message and data
            return response()->json([
                'success' => true,
                'message' => 'Jewels fetched successfully',
                'data' => $jewels
            ]);
        } catch (\Exception $e) {
            // Return JSON response with error message
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch jewels',
                'error' => $e->getMessage()
            ], 500); // HTTP 500 Internal Server Error
        }
    }

    public function show_jewe($id)
    {
        $jewel = Jewel::findOrFail($id);  // Find the jewel by ID or throw a 404 error
        $jewel->jewel_image = asset($jewel->jewel_image);

        return view('user.view', compact('jewel'));
    }

    public function showJewelStatus($id)
    {
        $userId = Auth::id();

        // Fetch the jewel based on the jewel ID and the authenticated user ID
        $jewelle = JewelQuery::where('id', $id)->where('user_id', $userId)->firstOrFail();
    
        // Pass the fetched jewel data to the view
        return view('user.status', compact('jewelle'));
    }

    // public function showcustomizationqueries() {
    //     $userId = Auth::id();
    //     $showcustomizationqueries = UserQueries::with('id') // Assuming 'jewel' is a defined relationship
    //         ->where('id',w $userId);    
    //     return view('user.myqueries', compact('showcustomizationqueries'));
    // }
    public function showcustomizationqueries() {
        $showcustomizationqueries = Customqueries::all();
        return view('user.myqueries', compact('showcustomizationqueries'));
    }

    public function getpurchase(){
        $fetchpurchase = Purchase::all();
        return view('smith.payment-status',compact('fetchpurchase')); 
    }

    
    

    
}



