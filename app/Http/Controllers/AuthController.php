<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
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
}
