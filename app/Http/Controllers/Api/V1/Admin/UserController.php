<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/admin/users",
     *      operationId="getUsersList",
     *      tags={"User Management"},
     *      summary="Get list of users",
     *      description="Returns paginated list of users (Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Items per page (max 50)",
     *          required=false,
     *          @OA\Schema(type="integer", default=15)
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number",
     *          required=false,
     *          @OA\Schema(type="integer", default=1)
     *      ),
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="Search in name and email",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="role",
     *          in="query",
     *          description="Filter by role",
     *          required=false,
     *          @OA\Schema(type="string", enum={"super-admin", "admin"})
     *      ),
     *      @OA\Parameter(
     *          name="is_active",
     *          in="query",
     *          description="Filter by status",
     *          required=false,
     *          @OA\Schema(type="boolean")
     *      ),
     *      @OA\Response(response=200, description="Users retrieved successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized - Admin only")
     *  )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $users->getCollection()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_active' => $user->is_active,
                'created_at' => $user->created_at->toIso8601String(),
                'updated_at' => $user->updated_at->toIso8601String(),
            ];
        });

        return $this->paginatedResponse($users, 'Users retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/admin/users/{id}",
     *      operationId="getUserDetail",
     *      tags={"User Management"},
     *      summary="Get user detail",
     *      description="Returns user detail by ID (Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="User retrieved successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized"),
     *      @OA\Response(response=404, description="User not found")
     *  )
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'created_at' => $user->created_at->toIso8601String(),
            'updated_at' => $user->updated_at->toIso8601String(),
        ];

        return $this->successResponse($data, 'User retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/users",
     *      operationId="createUser",
     *      tags={"User Management"},
     *      summary="Create new user",
     *      description="Create new user account (Super Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","email","password","role"},
     *              @OA\Property(property="name", type="string", example="New Admin"),
     *              @OA\Property(property="email", type="string", format="email", example="newadmin@pmdkatingan.go.id"),
     *              @OA\Property(property="password", type="string", format="password", example="Password123!"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="Password123!"),
     *              @OA\Property(property="role", type="string", enum={"super-admin", "admin"}, example="admin"),
     *              @OA\Property(property="is_active", type="boolean", example=true)
     *          )
     *      ),
     *      @OA\Response(response=201, description="User created successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized - Super Admin only"),
     *      @OA\Response(response=422, description="Validation error")
     *  )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:super-admin,admin'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'created_at' => $user->created_at->toIso8601String(),
        ];

        return $this->successResponse($data, 'User created successfully', 201);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/admin/users/{id}",
     *      operationId="updateUser",
     *      tags={"User Management"},
     *      summary="Update user",
     *      description="Update user information (Super Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Updated Name"),
     *              @OA\Property(property="email", type="string", format="email", example="updated@pmdkatingan.go.id"),
     *              @OA\Property(property="role", type="string", enum={"super-admin", "admin"}, example="admin"),
     *              @OA\Property(property="is_active", type="boolean", example=true)
     *          )
     *      ),
     *      @OA\Response(response=200, description="User updated successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized"),
     *      @OA\Response(response=404, description="User not found"),
     *      @OA\Response(response=422, description="Validation error")
     *  )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        // Prevent self-role change
        if ($user->id === $request->user()->id && $request->filled('role')) {
            return $this->errorResponse('You cannot change your own role', 403);
        }

        // Prevent self-deactivation
        if ($user->id === $request->user()->id && $request->filled('is_active') && !$request->boolean('is_active')) {
            return $this->errorResponse('You cannot deactivate your own account', 403);
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['sometimes', 'in:super-admin,admin'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $user->update($validated);

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'updated_at' => $user->updated_at->toIso8601String(),
        ];

        return $this->successResponse($data, 'User updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/users/{id}",
     *      operationId="deleteUser",
     *      tags={"User Management"},
     *      summary="Delete user",
     *      description="Delete user account (Super Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="User deleted successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized or cannot delete self"),
     *      @OA\Response(response=404, description="User not found")
     *  )
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        // Prevent self-deletion
        if ($user->id === $request->user()->id) {
            return $this->errorResponse('You cannot delete your own account', 403);
        }

        // Revoke all tokens before deletion
        $user->tokens()->delete();

        $user->delete();

        return $this->successResponse(null, 'User deleted successfully');
    }

    /**
     * @OA\Put(
     *      path="/api/v1/admin/users/{id}/reset-password",
     *      operationId="resetUserPassword",
     *      tags={"User Management"},
     *      summary="Reset user password",
     *      description="Reset password for specific user (Super Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"password","password_confirmation"},
     *              @OA\Property(property="password", type="string", format="password", example="NewPassword123!"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="NewPassword123!")
     *          )
     *      ),
     *      @OA\Response(response=200, description="Password reset successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized"),
     *      @OA\Response(response=404, description="User not found"),
     *      @OA\Response(response=422, description="Validation error")
     *  )
     */
    public function resetPassword(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Revoke all tokens to force re-login
        $user->tokens()->delete();

        return $this->successResponse(null, 'Password reset successfully. User must login again.');
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/users/{id}/toggle-status",
     *      operationId="toggleUserStatus",
     *      tags={"User Management"},
     *      summary="Toggle user active status",
     *      description="Activate or deactivate user account (Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="User status toggled successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Unauthorized or cannot toggle self"),
     *      @OA\Response(response=404, description="User not found")
     *  )
     */
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        // Prevent self-status toggle
        if ($user->id === $request->user()->id) {
            return $this->errorResponse('You cannot toggle your own status', 403);
        }

        $user->update(['is_active' => !$user->is_active]);

        // Revoke tokens if deactivated
        if (!$user->is_active) {
            $user->tokens()->delete();
        }

        $message = $user->is_active ? 'User activated successfully' : 'User deactivated successfully';

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'is_active' => $user->is_active,
        ];

        return $this->successResponse($data, $message);
    }
}
