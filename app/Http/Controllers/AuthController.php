<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle an admin login request.
     *
     * @param  \App\Http\Requests\UserLoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function userLogin(UserLoginRequest $request)
    {
        $user = User::where(['email' => $request->email, 'is_admin' => false])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $user->createToken("user." . $user->email, ['user'])->plainTextToken,
            'data' => $user,
            'message' => 'User login successfully'
        ]);
    }

    /**
     * Handle an admin login request.
     *
     * @param  \App\Http\Requests\AdminLoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminLogin(AdminLoginRequest $request)
    {
        $user = User::where(['email' => $request->email, 'is_admin' => true])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken("admin." . $user->name, ['admin'])->plainTextToken,
            'data' => $user,
            'message' => 'Admin login successfully'
        ]);
    }

    /**
     * Request user info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        return response()->json([
            'data' => Auth::user(),
            'message' => 'User fetch successfully'
        ]);
    }

    /**
     * Handle an admin logout request.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'data' => [],
            'message' => 'User logout successfully'
        ]);
    }

    /**
     * Handle a user registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:\App\Models\User,email',
            'password' => 'required|min:6|max:12|confirmed',
            'phone' => 'required|min:10|max:16'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }


        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'is_admin' => 0,
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'token' => $user->createToken("user." . $user->email, ['user'])->plainTextToken,
            'data' => $user,
            'message' => 'User registered successfully'
        ]);
    }
}
