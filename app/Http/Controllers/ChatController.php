<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Message;
class ChatController extends Controller
{
//     public function chat()
// {
//     $loggedInUserId = Auth::id();
//     $users = User::where('id', '!=', $loggedInUserId)->get();

//     // Fetch messages from the database (assuming you have a Message model and messages table)
//     $messages = Message::where('receiver_id', $loggedInUserId)->with('sender')->get(); // Adjust as needed

//     return view('home.chat', compact('users', 'messages'));
// }

public function chat()
{
    $loggedInUser = Auth::user(); // Get the logged-in user
    $users = User::all(); // Get all users for admin

    return view('home.chat', compact('users', 'loggedInUser'));
}

public function fetchContacts(Request $request)
{
    \Log::info('User is checking fetchContacts', ['user' => Auth::user()]);

    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    $loggedInUser = Auth::user();
    
    \Log::info('Logged in user', ['usertype' => $loggedInUser->usertype]);

    if (!$loggedInUser->usertype) {
        return response()->json(['success' => false, 'message' => 'User type not found'], 400);
    }

    // Fetch users and filter
    $users = User::all();
    $contacts = $users->filter(function($user) use ($loggedInUser) {
        return ($loggedInUser->usertype === 'admin' && $user->usertype !== 'admin') ||
               ($loggedInUser->usertype !== 'user' && $user->usertype === 'user');
    });

    return response()->json([
        'success' => true,
        'data' => $contacts->values(),
    ]);
}



public function fetch_Contacts(Request $request)
{
    // Log the action for debugging
    \Log::info('Fetching contacts', ['input' => $request->all()]);

    // Get the usertype filter from the request
    $filterUsertype = $request->input('usertype');

    // Fetch all users
    $users = User::all();

    // Filter users based on the provided usertype
    if ($filterUsertype) {
        $contacts = $users->filter(function($user) use ($filterUsertype) {
            // If usertype is 'user', return only 'admin' users
            if ($filterUsertype === 'user') {
                return $user->usertype === 'admin';
            }
            // If usertype is 'admin', return only 'user' users
            elseif ($filterUsertype === 'admin') {
                return $user->usertype === 'user';
            }
            // Otherwise, no filtering
            return false;
        });
    } else {
        // If no filter is provided, return all users
        $contacts = $users;
    }

    // Return the response as JSON
    return response()->json([
        'success' => true,
        'data' => $contacts->values(),
    ]);
}


public function android_chat($user1_id, $user2_id)
{
    // Get user1 and user2 by their IDs, or return a 404 if not found
    $user1 = User::find($user1_id);
    $user2 = User::find($user2_id);

    // Check if either user is missing
    if (!$user1 || !$user2) {
        return abort(404, 'One or both users not found.');
    }

    // Log user data for debugging purposes
    \Log::info('User1:', ['id' => $user1->id, 'name' => $user1->name]);
    \Log::info('User2:', ['id' => $user2->id, 'name' => $user2->name]);

    // Return the chat view with the two users
    return view('home.androidchat', compact('user1', 'user2'));
}



}
