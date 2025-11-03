@extends('layouts.admin.app')

@section('title', 'Tambah User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
            Tambah User
        </h1>
        <p class="mt-2 text-sm text-gray-600">
            Buat akun user baru untuk mengakses panel admin
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <x-admin.user-form :action="route('admin.users.store')" />
    </div>
</div>
@endsection
