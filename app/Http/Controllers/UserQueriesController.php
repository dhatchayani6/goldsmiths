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
            return redirect()->back()->withErrors('Jewel not found');
        }

        // Pass the jewel ID to the view
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
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url'); // Corrected field name
            $imageName = time() . '.' . $image->getClientOriginalExtension();
    
            // Save image to the public/images directory
            $imagePath = 'images/' . $imageName;
            $image->move(public_path('images'), $imageName);
        } else {
            // Return an error response if the image file is missing
            return response()->json(['message' => 'Image file is required.'], 400);
        }
    
        // Create a new UserQuery record
        UserQueries::create([
            'jewel_id' => $validated['jewel_id'],
            'user_id' => $validated['user_id'],
            'image_url' => $imagePath, // Save the path to the image
            'query' => $validated['query'],
        ]);
    
        return response()->json(['message' => 'Query submitted successfully!']);
    }

    public function getCustomQueries()
    {
        $userQueries = UserQueries::all(); // Fetch all user queries
    
        return view('smith.query-customization', compact('userQueries')); // Pass data to the view
    }
    
}
