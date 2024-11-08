<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{
    /**
     * Log the user in and return a token.
     */
    public function login(AuthLoginRequest $request)
    {


        // Check if the user exists and the password is correct
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate a token for the authenticated user
        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->success( 'Successfully logged in', ['user' => $user,'token' => $token]);
    }

    /**
     * Log the user out (revoke token).
     */
    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->success('Successfully logged out');
    }

    /**
     * Register a new user.
     */
    public function register(AuthRegisterRequest $request)
    {
      

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Create a token for the new user
        $token = $user->createToken('laravel-api-token')->plainTextToken;

        return response()->success( 'Successfully logged in', ['user' => $user,'token' => $token]);
    }
}
