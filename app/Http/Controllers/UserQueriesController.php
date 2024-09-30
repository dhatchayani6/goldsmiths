<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserQueries;
use App\Models\Jewel;


class UserQueriesController extends Controller
{
    public function create($id)
    {
        // Fetch the specific jewel by id
        $jewel = Jewel::find($id);

        // Check if the jewel exists
        if (!$jewel) {
            // If the request expects a JSON response, return JSON with an error message
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jewel not found'
                ], 404);
            }

            // Otherwise, redirect back with an error
            return redirect()->back()->withErrors('Jewel not found');
        }

        // Generate the full URL for the jewel image
        $jewel->jewel_image = asset($jewel->jewel_image);

        // If the request expects a JSON response, return JSON with success message and jewel data
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jewel found successfully',
                'data' => [
                    'jewelId' => $jewel->id,
                ]
            ], 200);
        }

        // Otherwise, return the view with the jewel data
        return view('user.customize-jewel', ['jewelId' => $jewel->id]);
    }



    public function store_customize(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'jewel_id' => 'required|exists:jewels,id',
        'user_id' => 'required|exists:users,id',
        'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image file
        'query' => 'required|string',
    ]);

    // Handle the image upload
    $imagePath = null; // Initialize image path to null
    if ($request->hasFile('image_url')) {
        $image = $request->file('image_url'); // Get the uploaded image
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Save image to the public/images directory
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
    } else {
        // Return an error response if the image file is missing
        return response()->json(['message' => 'Image file is required.'], 400);
    }

    // Create a new UserQuery record
    try {
        $userQuery = UserQueries::create([
            'jewel_id' => $validated['jewel_id'],
            'user_id' => $validated['user_id'],
            'image_url' => $imagePath, // Save the path to the image
            'query' => $validated['query'],
        ]);
    } catch (\Exception $e) {
        // Handle any errors that occur during record creation
        return response()->json(['message' => 'Failed to submit query: ' . $e->getMessage()], 500);
    }

    // Return a JSON response with success message and created data
    return response()->json([
        'success' => true,
        'message' => 'Query submitted successfully!',
        'data' => [
            'id' => $userQuery->id,
            'jewel_id' => $userQuery->jewel_id,
            'user_id' => $userQuery->user_id,
            'image_url' => asset($userQuery->image_url), // Full URL for the image
            'query' => $userQuery->query,
        ],
    ], 201);
}




    public function getCustomQueries()
    {
        $userQueries = UserQueries::all(); // Fetch all user queries

        return view('smith.query-customization', compact('userQueries')); // Pass data to the view
    }

    public function accept($id)
    {
        $query = UserQueries::find($id);
        if ($query) {
            $query->status = 'accepted';
            $query->save();

            return response()->json(['message' => 'Query accepted successfully.']);
        }

        return response()->json(['message' => 'Query not found.'], 404);
    }

    public function reject($id)
    {
        $query = UserQueries::find($id);
        if ($query) {
            $query->status = 'rejected';
            $query->save();

            return response()->json(['message' => 'Query rejected successfully.']);
        }

        return response()->json(['message' => 'Query not found.'], 404);
    }




}
