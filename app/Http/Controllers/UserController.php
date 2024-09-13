<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Models\Jewel;

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

}
