@props([
    'action',
    'method' => 'POST',
    'user' => null,
    'isEdit' => false
])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $user->name ?? '') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') @enderror"
                       placeholder="Nama lengkap user"
                       required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', $user->email ?? '') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') @enderror"
                       placeholder="email@example.com"
                       required>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password @if($isEdit)<span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>@else<span class="text-red-500">*</span>@endif
                </label>
                <input type="password"
                       name="password"
                       id="password"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') @enderror"
                       placeholder="Minimal 8 karakter"
                       {{ $isEdit ? '' : 'required' }}>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if(!$isEdit)
                    <p class="mt-1 text-sm text-gray-500">
                        Password harus minimal 8 karakter
                    </p>
                @endif
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password @if($isEdit)<span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>@else<span class="text-red-500">*</span>@endif
                </label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Ketik ulang password"
                       {{ $isEdit ? '' : 'required' }}>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Role Selection -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Role & Hak Akses</h3>

                <div class="space-y-3">
                    <div class="flex items-start">
                        <input type="radio"
                               name="role"
                               id="role_admin"
                               value="admin"
                               {{ old('role', $user->role ?? 'admin') === 'admin' ? 'checked' : '' }}
                               class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <label for="role_admin" class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Admin</div>
                            <p class="text-xs text-gray-500">Akses ke semua panel kecuali Kelola User</p>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="radio"
                               name="role"
                               id="role_super_admin"
                               value="super-admin"
                               {{ old('role', $user->role ?? '') === 'super-admin' ? 'checked' : '' }}
                               class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <label for="role_super_admin" class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Super Admin</div>
                            <p class="text-xs text-gray-500">Akses penuh ke semua panel termasuk Kelola User</p>
                        </label>
                    </div>
                </div>

                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Permissions Info -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="text-xs text-gray-600 space-y-2">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Super Admin memiliki kontrol penuh termasuk mengelola user lain</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Admin dapat mengelola konten website tetapi tidak dapat mengelola user</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status Akun</h3>

                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           id="is_active"
                           value="1"
                           {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Akun Aktif
                    </label>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    User yang dinonaktifkan tidak dapat login ke sistem
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $isEdit ? 'Perbarui' : 'Simpan' }} User
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
