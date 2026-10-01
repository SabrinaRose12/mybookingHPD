@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-10 animate-fade-in-up">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('profile.show') }}" class="flex h-9 w-9 items-center justify-center rounded-xl bg-white border border-[#eef1f8] hover:bg-purple-50 hover:border-purple-200 text-[#64748b] hover:text-purple-700 transition-all">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500/10 to-indigo-500/10 border border-purple-500/20 text-xs font-semibold text-purple-700">
                <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                Account Settings
            </div>
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-[#0f1419]">Edit <span class="text-gradient-blue">Profile</span></h1>
        <p class="mt-2 text-sm text-[#64748b]">Update your personal information and account settings.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-5 rounded-2xl bg-red-50 border border-red-200 animate-fade-in-up">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 border border-red-200 flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-red-800 mb-1">Please fix the errors below:</p>
                    @foreach($errors->all() as $error)
                        <p class="text-xs text-red-700 leading-relaxed">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-5 rounded-2xl bg-emerald-50 border border-emerald-200 animate-fade-in-up">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 border border-emerald-200 flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        {{-- Profile Form --}}
        <form action="{{ route('profile.update') }}" method="POST" class="modern-card p-6 md:p-8 space-y-5 animate-fade-in-up">
            @csrf @method('PUT')

            <h3 class="text-lg font-extrabold text-[#0f1419] flex items-center gap-3 pb-4 border-b border-[#eef1f8]">
                <div class="icon-container h-10 w-10" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                    <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                Personal Information
            </h3>

            <div>
                <label for="name" class="block text-sm font-bold text-[#334155] mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="auth-input pl-4 pr-4 {{ $errors->has('name') ? 'is-error' : '' }}">
                @error('name')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-[#334155] mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="auth-input pl-4 pr-4 {{ $errors->has('email') ? 'is-error' : '' }}">
                @error('email')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-sm font-bold text-[#334155] mb-2">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required
                           placeholder="0123456789"
                           class="auth-input pl-4 pr-4 {{ $errors->has('phone') ? 'is-error' : '' }}">
                    @error('phone')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="office_no" class="block text-sm font-bold text-[#334155] mb-2">Office Ext <span class="text-[#94a3b8] font-medium">(optional)</span></label>
                    <input type="text" id="office_no" name="office_no" value="{{ old('office_no', $user->office_no) }}"
                           placeholder="301"
                           class="auth-input pl-4 pr-4">
                    @error('office_no')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-[#334155] mb-2">Description <span class="text-[#94a3b8] font-medium">(optional)</span></label>
                <textarea id="description" name="description" rows="3" placeholder="e.g., Department, office location, etc."
                          class="auth-input pl-4 pr-4 resize-none">{{ old('description', $user->description) }}</textarea>
                @error('description')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4 border-t border-[#eef1f8]">
                <button type="submit" class="btn-modern btn-primary w-full">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Profile
                </button>
            </div>
        </form>

        {{-- Password Form --}}
        <form action="{{ route('profile.password') }}" method="POST" class="modern-card p-6 md:p-8 space-y-5 animate-fade-in-up animate-fade-in-up-delay-1">
            @csrf @method('PUT')

            <h3 class="text-lg font-extrabold text-[#0f1419] flex items-center gap-3 pb-4 border-b border-[#eef1f8]">
                <div class="icon-container h-10 w-10" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.08));">
                    <svg class="h-4 w-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                Change Password
            </h3>

            <div>
                <label for="current_password" class="block text-sm font-bold text-[#334155] mb-2">Current Password <span class="text-red-500">*</span></label>
                <input type="password" id="current_password" name="current_password" required
                       class="auth-input pl-4 pr-4 {{ $errors->has('current_password') ? 'is-error' : '' }}">
                @error('current_password')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-bold text-[#334155] mb-2">New Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required minlength="8"
                           class="auth-input pl-4 pr-4 {{ $errors->has('password') ? 'is-error' : '' }}">
                    @error('password')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-[#334155] mb-2">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="auth-input pl-4 pr-4">
                </div>
            </div>

            <div class="pt-4 border-t border-[#eef1f8]">
                <button type="submit" class="btn-modern w-full" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.75rem 1.5rem; font-weight: 700; border-radius: 0.875rem; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection