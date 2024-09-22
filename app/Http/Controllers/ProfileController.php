<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show()
    {
        return view('home.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
{
    // Validate the request for the image
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // Allow certain image types
    ]);

    $user = Auth::user();

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Generate a unique file name
        $filename = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
        
        // Store the uploaded image in the public/images directory
        $request->file('profile_picture')->move(public_path('images'), $filename);
        
        // Update the user's profile picture path
        $user->profile_picture = 'images/' . $filename; // Store the relative path
    }

    $user->save();

    return response()->json(['success' => true]);
}

}
