<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('home.index');
    }


    public function home()
    {
        if (Auth::id()) {
            $user_type = Auth()->user()->usertype;
            if ($user_type == "admin") {
                return view('smith.smithhome');
            } elseif ($user_type == "user") {
                return view('user.userhome');
            } else {
                return "error";
            }
        }
    }
    public function login(Request $request)
    {
        try {
            // Validate the request input
            $validated = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Check if the user exists with the provided email
            $user = User::where('email', $request->input('email'))->first();

            // Verify user existence and password
            if ($user && Hash::check($request->input('password'), $user->password)) {
                // Log in the user
                Auth::login($user);

                return response()->json([
                    'success'=>true,
                    'message' => 'Login successfully',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // Validate the request input
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
                'mobile_number'=>'required|integer|min:10'
            ]);

            // Create a new user instance
            $register = new User();
            $register->name = $request->input('name');
            $register->email = $request->input('email');
            $register->password = Hash::make($request->input('password'));
            $register->mobile_number=$request->input('mobile_number');
            $register->save();

            return response()->json(['sucess'=>true,'message' => 'Registered successfully','data'=>$register], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An unexpected error occurred during registration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}


}
