@extends('layouts.admin.app')

@section('title', 'Edit Kontak')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Kontak
            </h2>
            <p class="text-sm text-gray-600 mt-1">Memperbarui informasi kontak</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Kontak Utama -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Kontak Utama</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $contact->email) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @else @enderror"
                                           placeholder="contoh@email.com" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Telepon <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $contact->phone) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @else @enderror"
                                           placeholder="0812-3456-7890">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- WhatsApp -->
                                <div>
                                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                                        WhatsApp <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $contact->whatsapp) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('whatsapp') border-red-500 @else @enderror"
                                           placeholder="6281234567890">
                                    @error('whatsapp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Format: 62xxxxxxxxxxx</p>
                                </div>
                            </div>
                        </div>

                        <!-- Media Sosial -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Media Sosial</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Facebook -->
                                <div>
                                    <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">
                                        Facebook <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $contact->facebook) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('facebook') border-red-500 @else @enderror"
                                           placeholder="https://facebook.com/username">
                                    @error('facebook')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">
                                        Instagram <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="url" name="instagram" id="instagram" value="{{ old('instagram', $contact->instagram) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('instagram') border-red-500 @else @enderror"
                                           placeholder="https://instagram.com/username">
                                    @error('instagram')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Twitter -->
                                <div>
                                    <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2">
                                        Twitter <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="url" name="twitter" id="twitter" value="{{ old('twitter', $contact->twitter) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('twitter') border-red-500 @else @enderror"
                                           placeholder="https://twitter.com/username">
                                    @error('twitter')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- YouTube -->
                                <div>
                                    <label for="youtube" class="block text-sm font-medium text-gray-700 mb-2">
                                        YouTube <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="url" name="youtube" id="youtube" value="{{ old('youtube', $contact->youtube) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('youtube') border-red-500 @else @enderror"
                                           placeholder="https://youtube.com/@channel">
                                    @error('youtube')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Alamat & Jam Kerja -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Alamat & Jam Kerja</h3>
                            <div class="space-y-6">
                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <textarea name="address" id="address" rows="3"
                                              class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @else @enderror"
                                              placeholder="Masukkan alamat lengkap kantor">{{ old('address', $contact->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Google Maps Embed -->
                                <div>
                                    <label for="google_maps_embed" class="block text-sm font-medium text-gray-700 mb-2">
                                        Google Maps Embed URL <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <textarea name="google_maps_embed" id="google_maps_embed" rows="2"
                                              class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('google_maps_embed') border-red-500 @else @enderror"
                                              placeholder="https://www.google.com/maps/embed?pb=...">{{ old('google_maps_embed', $contact->google_maps_embed) }}</textarea>
                                    @error('google_maps_embed')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Copy URL embed dari Google Maps untuk menampilkan peta interaktif</p>
                                </div>

                                <!-- Office Days -->
                                <div>
                                    <label for="office_days" class="block text-sm font-medium text-gray-700 mb-2">
                                        Hari Kerja <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <input type="text" name="office_days" id="office_days" value="{{ old('office_days', $contact->office_days) }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('office_days') border-red-500 @else @enderror"
                                           placeholder="Senin - Jumat">
                                    @error('office_days')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Office Hours -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="office_hours_open" class="block text-sm font-medium text-gray-700 mb-2">
                                            Jam Buka <span class="text-gray-400 text-xs">(Opsional)</span>
                                        </label>
                                        <input type="time" name="office_hours_open" id="office_hours_open" value="{{ old('office_hours_open', $contact->office_hours_open) }}"
                                               class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('office_hours_open') border-red-500 @else @enderror">
                                        @error('office_hours_open')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="office_hours_close" class="block text-sm font-medium text-gray-700 mb-2">
                                            Jam Tutup <span class="text-gray-400 text-xs">(Opsional)</span>
                                        </label>
                                        <input type="time" name="office_hours_close" id="office_hours_close" value="{{ old('office_hours_close', $contact->office_hours_close) }}"
                                               class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('office_hours_close') border-red-500 @else @enderror">
                                        @error('office_hours_close')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 pt-6 border-t">
                            <a href="{{ route('admin.contacts.index') }}"
                               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                Perbarui Kontak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
