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



}
