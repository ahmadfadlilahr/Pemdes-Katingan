@extends('layouts.admin.app')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
            Edit User
        </h1>
        <p class="mt-2 text-sm text-gray-600">
            Perbarui informasi user <strong>{{ $user->name }}</strong>
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <x-admin.user-form
            :action="route('admin.users.update', $user)"
            :user="$user"
            :isEdit="true"
        />
    </div>
</div>
@endsection
