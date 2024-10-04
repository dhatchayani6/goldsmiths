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

}
