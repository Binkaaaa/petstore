<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AdminAuthController extends Controller
{
public function login(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Find user with admin user_type
    $user = User::where('email', $request->email)
                ->where('user_type', 'admin')
                ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid login credentials'
        ], 403);
    }

    if (!$user) {
        return response()->json([
            'message' => 'No admin user found with this email'
        ], 404);
    
    }
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Password does not match'
        ], 401);
    }

    // Create Sanctum token
    $token = $user->createToken('admin-token')->plainTextToken;

    // Return token and user info
    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => $user->user_type,
        ],
    ]);
}

}