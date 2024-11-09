<?php

namespace App\Http\Controllers;


use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{
    protected AuthService $authService;
    
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    /**
     * Log the user in and return a token.
     * 
     * @param AuthLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request) : JsonResponse
    {

        $user = $this->authService->login($request->validated());

        if(!$user){
            return response()->error( 'Invalid credentials', 401);
        }

        return response()->success( 'Successfully logged in', [
            'user' => $user,
            'token' => $user->createToken('laravel-api-token')->plainTextToken
        ]);
    }

    /**
     * Log the user out (revoke token).
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) : JsonResponse
    {
        
        $this->authService->logout($request->user());

        return response()->success('Logged out successfully');
    }

    /**
     * Register a new user.
     * 
     * @param AuthRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRegisterRequest $request) : JsonResponse
    {

        $user = $this->authService->register($request->validated());

        // Create a token for the new user
        $token = $user->createToken('laravel-api-token')->plainTextToken;

        return response()->success( 'Account Created Successfully!', ['user' => $user,'token' => $token], 201);
    }
}
