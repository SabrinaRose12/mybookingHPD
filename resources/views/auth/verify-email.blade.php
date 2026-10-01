@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
            <p class="mt-2 text-sm text-gray-600">
                Thank you for registering! Before you begin, please verify your email by clicking the link we just sent to <strong>{{ auth()->user()->email }}</strong>.
            </p>
            <p class="mt-2 text-sm text-gray-600">
                If you didn't receive the email, you can request a new one.
            </p>
        </div>

        @if (session('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Resend Verification Link
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-indigo-600 hover:text-indigo-500">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection