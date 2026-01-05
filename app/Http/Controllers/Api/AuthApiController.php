<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);
        $ttl = JWTAuth::factory()->getTTL() * 60;

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_in' => $ttl,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = JWTAuth::fromUser($user);
        $ttl = JWTAuth::factory()->getTTL() * 60;

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_in' => $ttl,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            // Try to revoke/invalidate the token provided in the Authorization header.
            $header = $request->header('Authorization', '') ?: $request->bearerToken();
            $token = null;
            if ($header && str_starts_with($header, 'Bearer ')) {
                $token = substr($header, 7);
            } elseif ($header) {
                $token = $header;
            }

            // Fallbacks for servers that don't forward Authorization header
            if (!$token) {
                $token = $request->header('X-Api-Token') ?: $request->query('token') ?: $request->input('token');
            }

            JWTAuth::revokeToken($token);
        } catch (\Exception $e) {
            // Token missing or already invalid
        }

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
