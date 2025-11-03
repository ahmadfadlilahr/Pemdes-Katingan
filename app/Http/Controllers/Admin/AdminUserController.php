<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['super-admin', 'admin'])],
            'is_active' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['super-admin', 'admin'])],
            'is_active' => 'nullable|boolean',
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUserId = Auth::id();

        // Prevent deleting own account
        if ($currentUserId && $user->id === $currentUserId) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Prevent deleting the last super admin
        if ($user->isSuperAdmin() && User::superAdmins()->count() <= 1) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus Super Admin terakhir!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        $currentUserId = Auth::id();

        // Prevent deactivating own account
        if ($currentUserId && $user->id === $currentUserId) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        // Prevent deactivating the last active super admin
        if ($user->isSuperAdmin() && $user->isActive() && User::superAdmins()->active()->count() <= 1) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menonaktifkan Super Admin terakhir yang aktif!');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Status user berhasil diubah!');
    }
}
