<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/auth/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Login to get API token",
     *      description="Authenticate user and return API token for subsequent requests",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="admin@pmdkatingan.go.id"),
     *              @OA\Property(property="password", type="string", format="password", example="password"),
     *              @OA\Property(property="device_name", type="string", example="Swagger UI")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Login successful"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="token", type="string", example="1|abcdefghijklmnopqrstuvwxyz"),
     *                  @OA\Property(property="token_type", type="string", example="Bearer"),
     *                  @OA\Property(
     *                      property="user",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Administrator"),
     *                      @OA\Property(property="email", type="string", example="admin@pmdkatingan.go.id"),
     *                      @OA\Property(property="role", type="string", example="super-admin"),
     *                      @OA\Property(property="is_active", type="boolean", example=true)
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=401, description="Invalid credentials"),
     *      @OA\Response(response=403, description="Account inactive")
     *  )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['nullable', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('The provided credentials are incorrect.', 401);
        }

        if (!$user->is_active) {
            return $this->error('Your account is inactive. Please contact administrator.', 403);
        }

        // Revoke all previous tokens (optional - for single session)
        // $user->tokens()->delete();

        $token = $user->createToken($request->device_name ?? 'API Token')->plainTextToken;

        $data = [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_active' => $user->is_active,
            ],
        ];

        return $this->success($data, 'Login successful');
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth/logout",
     *      operationId="logout",
     *      tags={"Authentication"},
     *      summary="Logout and revoke token",
     *      description="Revoke current API token",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Logout successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Logout successful")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthenticated")
     *  )
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logout successful');
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth/logout-all",
     *      operationId="logoutAll",
     *      tags={"Authentication"},
     *      summary="Logout from all devices",
     *      description="Revoke all API tokens for current user",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Logged out from all devices",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Logged out from all devices")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthenticated")
     *  )
     */
    public function logoutAll(Request $request): JsonResponse
    {
        // Revoke all tokens
        $request->user()->tokens()->delete();

        return $this->success(null, 'Logged out from all devices');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/auth/me",
     *      operationId="getCurrentUser",
     *      tags={"Authentication"},
     *      summary="Get current authenticated user",
     *      description="Returns current user information",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="User retrieved successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="User retrieved successfully"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Administrator"),
     *                  @OA\Property(property="email", type="string", example="admin@pmdkatingan.go.id"),
     *                  @OA\Property(property="role", type="string", example="super-admin"),
     *                  @OA\Property(property="is_active", type="boolean", example=true),
     *                  @OA\Property(property="created_at", type="string", example="2025-01-01T00:00:00+07:00")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthenticated")
     *  )
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'created_at' => $user->created_at->toIso8601String(),
        ];

        return $this->success($data, 'User retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/api/v1/auth/update-profile",
     *      operationId="updateProfile",
     *      tags={"Authentication"},
     *      summary="Update current user profile",
     *      description="Update name and email of current user",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Updated Name"),
     *              @OA\Property(property="email", type="string", format="email", example="newemail@pmdkatingan.go.id")
     *          )
     *      ),
     *      @OA\Response(response=200, description="Profile updated successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=422, description="Validation error")
     *  )
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        return $this->success($data, 'Profile updated successfully');
    }

    /**
     * @OA\Put(
     *      path="/api/v1/auth/change-password",
     *      operationId="changePassword",
     *      tags={"Authentication"},
     *      summary="Change current user password",
     *      description="Change password for current authenticated user",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"current_password","password","password_confirmation"},
     *              @OA\Property(property="current_password", type="string", format="password"),
     *              @OA\Property(property="password", type="string", format="password"),
     *              @OA\Property(property="password_confirmation", type="string", format="password")
     *          )
     *      ),
     *      @OA\Response(response=200, description="Password changed successfully"),
     *      @OA\Response(response=401, description="Unauthenticated or invalid current password"),
     *      @OA\Response(response=422, description="Validation error")
     *  )
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return $this->error('Current password is incorrect', 401);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Revoke all tokens except current
        $user->tokens()->where('id', '!=', $request->user()->currentAccessToken()->id)->delete();

        return $this->success(null, 'Password changed successfully. Please login again on other devices.');
    }
}
