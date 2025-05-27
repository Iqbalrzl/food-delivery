<?php

// app/Http/Controllers/Api/AuthController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'firebase_uid' => 'required|string',
                'email' => 'required|email',
            ]);

            $user = User::where('firebase_uid', $request->firebase_uid)->first();

            if (!$user) {
                $user = User::create([
                    'firebase_uid' => $request->firebase_uid,
                    'email' => $request->email,
                ]);
            }

            return response()->json([
                'message' => 'User registered successfully.',
                'user' => $user,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUserIdByFirebaseUid(Request $request)
    {
        $firebaseUid = $request->header('firebase_uid');

        if (!$firebaseUid) {
            return response()->json(['error' => 'firebase_uid not found in header'], 400);
        }

        $user = User::where('firebase_uid', $firebaseUid)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user_id' => $user->id]);
    }
}