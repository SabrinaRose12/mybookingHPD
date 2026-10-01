@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

    <div class="max-w-5xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-10 animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500/10 to-indigo-500/10 border border-purple-500/20 text-xs font-semibold text-purple-700 mb-4">
                <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                Account
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-[#0f1419]">My <span class="text-gradient-blue">Profile</span></h1>
            <p class="mt-2 text-sm text-[#64748b]">View and manage your account information.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Profile Card --}}
            <div class="lg:col-span-1">
                <div class="modern-card p-6 text-center animate-fade-in-up">

                    {{-- Avatar --}}
                    <div class="flex justify-center mb-5 relative">
                        <div class="absolute inset-0 bg-purple-500/20 rounded-full blur-2xl"></div>
                        <div class="relative h-24 w-24 rounded-full bg-gradient-to-br from-purple-500 via-indigo-500 to-pink-500 flex items-center justify-center text-3xl font-extrabold text-white shadow-xl shadow-purple-500/30 ring-4 ring-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>

                    <h2 class="text-xl font-extrabold text-[#0f1419]">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-[#94a3b8] mt-1 font-medium">{{ auth()->user()->email }}</p>

                    <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold
                                {{ auth()->user()->isSuper() ? 'bg-amber-50 text-amber-700 border border-amber-200' :
                                   (auth()->user()->isAdmin() ? 'bg-purple-50 text-purple-700 border border-purple-200' :
                                   'bg-slate-100 text-slate-600 border border-slate-200') }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ auth()->user()->isSuper() ? 'bg-amber-500' : (auth()->user()->isAdmin() ? 'bg-purple-500' : 'bg-slate-400') }}"></span>
                        {{ auth()->user()->isSuper() ? 'Super Admin' : (auth()->user()->isAdmin() ? 'Admin (PIC)' : 'User') }}
                    </div>

                    @if(auth()->user()->isAdmin() && !auth()->user()->isSuper())
                        <div class="mt-5 p-4 bg-[#fafbff] rounded-xl border border-[#eef1f8] text-left">
                            <p class="text-[10px] text-[#94a3b8] font-bold uppercase tracking-widest mb-2">Assigned Rooms</p>
                            @php
                                $assignedRooms = auth()->user()->assigned_rooms ?? [];
                                $roomNames = \App\Models\Room::whereIn('id', $assignedRooms)->pluck('name')->toArray();
                            @endphp
                            @if(!empty($roomNames))
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($roomNames as $name)
                                        <span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-lg border border-purple-200">
                                            {{ $name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-[#94a3b8] font-medium">No rooms assigned.</p>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 pt-6 border-t border-[#eef1f8]">
                        <a href="{{ route('profile.edit') }}" class="btn-modern btn-primary w-full">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right: Details --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Personal Information --}}
                <div class="modern-card p-6 animate-fade-in-up animate-fade-in-up-delay-1">
                    <h3 class="text-lg font-extrabold text-[#0f1419] mb-5 flex items-center gap-3">
                        <div class="icon-container h-10 w-10" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                            <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        Personal Information
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Full Name</p>
                            <p class="text-sm font-bold text-[#0f1419]">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Email</p>
                            <p class="text-sm font-bold text-[#0f1419] truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Phone Number</p>
                            <p class="text-sm font-bold text-[#0f1419]">{{ auth()->user()->phone ?? 'Not set' }}</p>
                        </div>
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Office Extension</p>
                            <p class="text-sm font-bold text-[#0f1419]">{{ auth()->user()->office_no ?? 'Not set' }}</p>
                        </div>
                    </div>

                    @if(auth()->user()->description)
                        <div class="mt-4 p-4 bg-[#fafbff] rounded-xl border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Description</p>
                            <p class="text-sm text-[#334155] font-medium">{{ auth()->user()->description }}</p>
                        </div>
                    @endif
                </div>

                {{-- Account Status --}}
                <div class="modern-card p-6 animate-fade-in-up animate-fade-in-up-delay-2">
                    <h3 class="text-lg font-extrabold text-[#0f1419] mb-5 flex items-center gap-3">
                        <div class="icon-container h-10 w-10" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.08));">
                            <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        Account Status
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-2">Status</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold
                                        {{ auth()->user()->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ auth()->user()->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-2">Email Verified</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold
                                        {{ auth()->user()->hasVerifiedEmail() ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ auth()->user()->hasVerifiedEmail() ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                {{ auth()->user()->hasVerifiedEmail() ? 'Verified' : 'Unverified' }}
                            </span>
                        </div>
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Member Since</p>
                            <p class="text-sm font-bold text-[#0f1419]">{{ auth()->user()->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                            <p class="text-[10px] text-[#94a3b8] uppercase tracking-widest font-bold mb-1">Last Updated</p>
                            <p class="text-sm font-bold text-[#0f1419]">{{ auth()->user()->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection