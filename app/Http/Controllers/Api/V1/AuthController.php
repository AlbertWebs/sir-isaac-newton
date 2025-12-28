<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Parent as ParentModel;
use App\Models\Driver;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login endpoint - supports multiple user types
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'user_type' => 'required|in:user,parent,driver,teacher',
        ]);

        $user = null;
        $token = null;

        switch ($request->user_type) {
            case 'user':
                $user = User::where('email', $request->email)->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('api-token')->plainTextToken;
                }
                break;

            case 'parent':
                $user = ParentModel::where('email', $request->email)->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('api-token')->plainTextToken;
                }
                break;

            case 'driver':
                $user = Driver::where('email', $request->email)
                    ->orWhere('phone', $request->email)
                    ->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('api-token')->plainTextToken;
                }
                break;

            case 'teacher':
                $user = Teacher::where('email', $request->email)
                    ->orWhere('employee_number', $request->email)
                    ->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('api-token')->plainTextToken;
                }
                break;
        }

        if (!$user || !$token) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $userName = match(true) {
            isset($user->name) => $user->name,
            isset($user->full_name) => $user->full_name,
            isset($user->first_name) => ($user->first_name . ' ' . ($user->last_name ?? '')),
            default => 'User'
        };

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $userName,
                'email' => $user->email ?? null,
                'type' => $request->user_type,
            ],
        ]);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}

