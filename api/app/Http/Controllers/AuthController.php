<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    //
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'userName' => 'required|unique:users|string:255',
            'email' => 'nullable|email|unique:users|required_without_all:phone',
            'phone' => 'nullable|numeric|min:9|unique:users|required_without_all:email',
            'password' => 'required|min:6',
            'role' => 'required'
        ], [
            'userName.unique' => 'This user name already exists',
            'email.unique' => 'This email address already exists',
            'phone.unique' => 'This phone number already exists',
            'email.required_without_all' => 'The email address or phone number cannot be empty.',
            'phone.required_without_all' => 'The email address or phone number cannot be empty.',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new user
        $user = User::create([
            'userName' => $request->userName,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'isActive' => true
        ]);

        if ($user) {
            // log the activity of the user
            logAction($request->userName, 'User Registration', 'Successful user registration', $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully registered as Role: {$request->role}", UserResource::make($user));
        }
    }

    //
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'userName' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!$user = User::where('userName', $request->userName)->first()) {
            logAction($request->userName, 'Failed Login', 'Failed Login - Incorrect Username', $request->ip(), $request->userAgent());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->password, $user->password)) {
            logAction($request->userName, 'Failed Login', 'Failed Login - Incorrect Password', $request->ip(), $request->userAgent());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        // $token = auth()->login($user);
        $token = $user->createToken('authToken')->plainTextToken;
        $data = [
            'authorization' => [
                'type' => 'Bearer',
                'token' => $token,
                'expires_in' => config('sanctum.expiration') * 60,
            ],
            'user' => UserResource::make($user),
        ];

        // save activity
        logAction($request->userName, 'Successful Login', 'Login Successful', $request->ip(), $request->userAgent());
        return successResponse('Login Successful', $data);
    }
}