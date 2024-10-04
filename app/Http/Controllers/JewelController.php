<?php

namespace App\Http\Controllers;

use App\Models\JewelQuery;
use Illuminate\Http\Request;
use App\Models\Jewel;

class JewelController extends Controller
{

    public function fetch_jewel(){
        $fetchjewels=Jewel::all();
        return response()->json([
            'success' => true,
            'message' => 'Jewelry added successfully!',
            'data' => $fetchjewels
        ], 201);
    }
    public function showjewel_page()
    {
        return view('smith.add_jewelery');
    }

    public function manage()
    {
        $manageJewels = Jewel::paginate(4);
        // \Log::info($manageJewels); // Log to check if data is fetched
        return view('smith.manage', compact('manageJewels'));
    }

    public function show_store_jewellery()
    {
        return view('smith.add_jewelery');
    }

    public function store_jewel(Request $request)
    {
        // Validate the request
        $request->validate([
            'jewelryName' => 'required|string|max:255',
            'jewelryType' => 'required|string|max:255',
            'jewelryWeight' => 'required|numeric',
            'jewelryPrice' => 'required|numeric|min:0',
            'jewelryDescription' => 'nullable|string',
            'jewelryImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            // Check if the request has an image file
            if ($request->hasFile('jewelryImage')) {
                $image = $request->file('jewelryImage');

                // Generate a unique name for the image
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                // Define the target path for the image
                $imagePath = '/' . 'images/' . $imageName;

                // Move the image to the 'public/images' directory
                $image->move(public_path('images'), $imageName);
            }

            // Create a new jewelry entry
            $jewelry = new Jewel();
            $jewelry->name = $request->input('jewelryName');
            $jewelry->type = $request->input('jewelryType');
            $jewelry->weight = $request->input('jewelryWeight');
            $jewelry->price = $request->input('jewelryPrice');
            $jewelry->description = $request->input('jewelryDescription');
            $jewelry->jewel_image = $imagePath; // Save the image path in the database
            $jewelry->save();

            return response()->json([
                'success' => true,
                'message' => 'Jewelry added successfully!',
                'data' => $jewelry
            ], 201);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to add jewelry: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        // Fetch the specific jewel by ID
        $jewel = Jewel::find($id);

        // If the jewel is not found, show an error or redirect
        if (!$jewel) {
            return redirect()->route('dashboard')->with('error', 'Jewel not found.');
        }

        // Return a view with the jewel details
        return view('user.view', compact('jewel'));
    }

    public function showQueries()
    {
        $queries = JewelQuery::all(); // Fetch all queries from the 'queries' table.
        return view('smith.show_queries', compact('queries'));
    }

    public function accept($id)
    {
        $query = JewelQuery::findOrFail($id);
        $query->status = 'Accepted'; // Adjust according to your status field
        $query->save();

        return response()->json(['success' => true]);
    }

    public function reject($id)
    {
        $query = JewelQuery::findOrFail($id);
        $query->status = 'Rejected'; // Adjust according to your status field
        $query->save();

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $jewel = Jewel::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Jewel retrieved successfully.',
            'data' => $jewel
        ]);
    }


    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $jewel = Jewel::findOrFail($id);
        $jewel->name = $request->name;
        $jewel->description = $request->description;
        $jewel->price = $request->price;
        $jewel->type = $request->type;

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $jewel->jewel_image = '/' . 'images/' . $imageName;
        }

        $jewel->save();

        return response()->json(['success' => true, 'message' => 'Jewel updated successfully!', compact('jewel')]);
    }

    public function destroy($id)
    {
        $jewel = Jewel::find($id);

        if (!$jewel) {
            return response()->json(['success' => false, 'message' => 'Jewel not found'], 404);
        }

        $jewel->delete();

        return response()->json(['success' => true, 'message' => 'Jewel deleted successfully', compact('jewel')], 200);
    }

}
