@extends('layouts.admin.app')

@section('title', 'Profile')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Profile</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola informasi akun dan keamanan Anda</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Profile Information Card -->
        <x-admin.profile.information-card :user="$user" />

        <!-- Update Password Card -->
        <x-admin.profile.password-card />

        <!-- Delete Account Card -->
        <x-admin.profile.delete-account-card />
    </div>
@endsection
