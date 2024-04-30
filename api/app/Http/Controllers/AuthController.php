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
    public function registerClient(Request $request): JsonResponse
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'firstName' => 'bail|required',
            'lastName' => 'bail|required',
            'userName' => 'bail|required|unique:users|min:7',
            'email' => 'bail|nullable|email|unique:users|required_without_all:phone',
            'phone' => 'bail|nullable|numeric|min:9|unique:users|required_without_all:email',
            'password' => 'bail|required|min:6',
            'worker' => 'bail|required'
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

        // create new client
        $user = User::create([
            'userName' => $request->userName,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'worker' => $request->worker,
            'role' => 'client',
            'isActive' => true
        ]);

        if ($user) {
            // log the activity of the user
            logAction($request->userName, 'Client Registration', 'Successful user registration as a Client', $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully registered as a Client", UserResource::make($user));
        }
    }

    //
    public function registerWorker(Request $request): JsonResponse
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'firstName' => 'bail|required',
            'lastName' => 'bail|required',
            'userName' => 'bail|required|unique:users|min:7',
            'email' => 'bail|nullable|email|unique:users|required_without_all:phone',
            'phone' => 'bail|nullable|numeric|min:9|unique:users|required_without_all:email',
            'password' => 'bail|required|min:6',
        ], [
            'userName.unique' => 'This user name already exists',
            'email.unique' => 'This email address already exists',
            'phone.unique' => 'This phone number already exists',
            'email.required_without_all' => 'The email address or phone number cannot be empty.',
            'phone.required_without_all' => 'The email address or phone number cannot be empty.',
        ]);

        // failed validation with response
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new health care worker
        $user = User::create([
            'userName' => $request->userName,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'worker',
            'isActive' => true
        ]);

        if ($user) {
            // log the activity of the user
            logAction($request->userName, 'Health Care Worker Registration', 'Successful user registration as Health Care Worker', $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully registered as a Health Care Worker", UserResource::make($user));
        }
    }

    //
    public function login(Request $request): JsonResponse
    {
        // validate the request
        $request->validate([
            'userName' => 'required|string',
            'password' => 'required|string',
        ]);
        // check if user exists
        if (!$user = User::where('userName', $request->userName)->first()) {
            logAction($request->userName, 'Failed Login', 'Failed Login - Incorrect Username', $request->ip(), $request->userAgent());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials - Incorrect Username.", [], Response::HTTP_UNAUTHORIZED);
        }
        // check password
        if (!Hash::check($request->password, $user->password)) {
            logAction($request->userName, 'Failed Login', 'Failed Login - Incorrect Password', $request->ip(), $request->userAgent());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials - Incorrect Password", [], Response::HTTP_UNAUTHORIZED);
        }

        // create token from credentials
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
