<?php

namespace App\Http\Controllers;

use App\Models\JewelQuery;
use Illuminate\Http\Request;
use App\Models\Jewel;

class JewelController extends Controller
{
    public function showjewel_page()
    {
        return view('smith.add_jewelery');
    }

    public function store_jewel(Request $request)
    {
        $request->validate([
            'jewelryName' => 'required|string|max:255',
            'jewelryType' => 'required|string|max:255',
            'jewelryWeight' => ['required', 'numeric'],
            'jewelryPrice' => 'required|numeric|min:0',
            'jewelryDescription' => 'required|nullable|string',
            'jewelryImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;
    
            // Handle image upload
            if ($request->hasFile('jewelryImage')) {
                $image = $request->file('jewelryImage');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
    
                // Save image to the public/images directory
                $imagePath = 'images/' . $imageName;
                $image->move(public_path('images'), $imageName);
            }
    
            // Store jewelry data
            $jewelry = new Jewel();
            $jewelry->name = $request->input('jewelryName');
            $jewelry->type = $request->input('jewelryType');
            $jewelry->weight = $request->input('jewelryWeight');
            $jewelry->price = $request->input('jewelryPrice');
            $jewelry->description = $request->input('jewelryDescription');
            $jewelry->jewel_image = $imagePath; // Store image name in database
            $jewelry->save();

            return response()->json([
                'success' => true,
                'message' => 'Jewelry added successfully!',
                'data' => $jewelry // Include the saved jewelry data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add jewelry: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
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
}
