<?php

namespace App\Http\Controllers;

use App;
use App\Models\Customqueries;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Jewel;
use Auth;
use App\Models\JewelQuery;



class UserController extends Controller
{
    public function fetch_jewels(Request $request)
    {
        try {
            // Fetch paginated jewels from the database
            $jewels = Jewel::paginate(4);

            // Return JSON response with success message and data
            return response()->json([
                'success' => true,
                'message' => 'Jewels fetched successfully',
                'data' => $jewels->items(), // Return only the items
                'links' => $jewels->links()->toHtml(), // Return pagination links as HTML
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

    // public function show_jewe($id)
    // {
    //     $jewel = Jewel::findOrFail($id);  // Find the jewel by ID or throw a 404 error
    //     $jewel->jewel_image = asset($jewel->jewel_image);

    //     return view('user.view', compact('jewel'));
    // }

    public function show_jewe($id)
    {
        // Find the jewel by ID or throw a 404 error
        $jewel = Jewel::findOrFail($id);

        // Prepare the jewel image URL
        $jewel->jewel_image = asset($jewel->jewel_image);

        // Check if the request expects a JSON response
        if (request()->wantsJson()) {
            // Return the jewel data with a success message as a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Jewel retrieved successfully',
                'data' => [
                    'id' => $jewel->id,
                    'name' => $jewel->name,
                    'description' => $jewel->description,
                    'price' => $jewel->price,
                    'jewel_image' => $jewel->jewel_image,
                    'created_at' => $jewel->created_at,
                    'updated_at' => $jewel->updated_at,
                ]
            ]);
        }

        // Otherwise, return the view with jewel data
        return view('user.view', compact('jewel'));
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Jewel retrived successfully',
        //     'data' => $jewel
        // ]);
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
    public function showcustomizationqueries()
    {
        // Fetch customization queries for the authenticated user
        $showcustomizationqueries = Customqueries::where('user_id', auth()->id())->get();

        return view('user.myqueries', compact('showcustomizationqueries'));
    }


    public function getpurchase()
    {
        $fetchpurchase = Purchase::all();
        return view('smith.payment-status', compact('fetchpurchase'));
    }

    public function fetchUserQueries()
    {
        // Fetch queries based on the authenticated user's ID
        $userQueries = JewelQuery::where('user_id', auth()->id())->get();

        // Return the view with the user's queries
        return view('user.query', compact('userQueries')); // Change 'your-view-name' to your actual view name
    }

    public function fetchUser_Queries($id)
    {
        // Fetch queries based on the authenticated user's ID
        $userQueries = JewelQuery::where('user_id',$id)->get();

        // Return the view with the user's queries
        // return view('user.query', compact('userQueries')); // Change 'your-view-name' to your actual view name
        return response()->json(['success'=>true,'message'=>'fetched user queries','data'=>$userQueries]);
    }


    public function showJewel_Status($id)
    {
        // Fetch the jewel based on the jewel ID and the user ID
        $jewelle = JewelQuery::where('user_id', $id)->first();

        // Check if a record was found
        if ($jewelle) {
            // Return the jewel status if the user exists with a 200 (success) status
            return response()->json([
                'success' => true,
                'message' => 'Status of jewel fetched successfully',
                'data' => $jewelle
            ], 200); // HTTP status 200 for success
        } else {
            // Return a "no user found" message with a 500 (failure) status
            return response()->json([
                'success' => false,
                'message' => 'No user found with the given ID'
            ], 500); // HTTP status 500 for failure
        }
    }

    public function showcustomization_queries($id)
    {
        // Fetch the customization query based on the provided user_id ($id)
        $showcustomizationqueries = Customqueries::where('user_id', $id)->get();
    
        // Check if queries were found
        if ($showcustomizationqueries->isNotEmpty()) {
            // Success: Return a success response with the query data
            return response()->json([
                'success' => true,
                'message' => 'Customization queries fetched successfully',
                'data' => $showcustomizationqueries
            ], 200); // HTTP 200 for success
        } else {
            // Failure: No query found, return a failure message
            return response()->json([
                'success' => false,
                'message' => 'No customization queries found for the given user ID'
            ], 500); // HTTP 404 for not found
        }
    }



    public function show_customization_queries($user_id)
{
    // Fetch the customization queries based on the provided user_id
    $showcustomizationqueries = Customqueries::where('user_id', $user_id)->get();

    // Return the result as JSON response
    return response()->json([
        'success' => true,
        'message' => 'Customization queries fetched successfully',
        'data' => $showcustomizationqueries
    ]);
}

    





}



