<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->userService->all();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'data' => $user,
            'message' => "User listing."
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:\App\Models\User,email',
            'password' => 'required|min:6|max:12|confirmed',
            'phone' => 'required|min:10|max:16'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $password = trim($request->password);
        $password = Hash::make($password);

        $user = $this->userService->create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password' => $password,
            'phone' => trim($request->phone),
        ]);

        if (!$user) {
            return response()->json(['message' => 'User not created'], 404);
        }

        return response()->json([
            'data' => $user,
            'message' => "User created successfully."
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'data' => $user,
            'message' => "User founds"
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->request->add(['id' => $id]);

        $rules = [
            'id' => 'required|exists:\App\Models\User,id',
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:\App\Models\User,email,' . $id,
            'phone' => 'required|min:10|max:16',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'nullable|min:6|max:12|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $updateData = [
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => trim($request->phone),
        ];

        if ($request->filled('password')) {
            $password = trim($request->password);
            $password = Hash::make($password);
            $updateData['password'] = $password;
        }

        $user = $this->userService->update($updateData, $id);

        if (!$user) {
            return response()->json(['message' => 'User not updated'], 404);
        }

        return response()->json([
            'data' => $user,
            'message' => "User updated successfully."
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id, 'is_admin' => 0], [
            'id' => 'required|exists:\App\Models\User,id',
            'is_admin' => 'exists:\App\Models\User,is_admin',
        ], messages: [
            'id' => 'User not found',
            'is_admin' => 'Selected user is admin.'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $this->userService->delete($id);

        return response()->json([
            'data' => [],
            'message' => "User deleted successfully."
        ], 200);
    }
}
