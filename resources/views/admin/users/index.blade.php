@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')

    {{-- ═══ Hero Banner ═══ --}}
    <x-hero-banner 
        title="Manage Users"
        subtitle="Add, edit, and manage all user accounts in the system."
        :label="'Super Admin · ' . now()->format('l, d F Y')">

        <a href="{{ route('admin.users.create') }}" class="hero-btn">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add New User
        </a>
    </x-hero-banner>

    <div class="modern-card overflow-hidden animate-fade-in-up">
        @if($users->isEmpty())
            <div class="p-16 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-purple-50 border border-purple-200 mb-6">
                    <svg class="h-10 w-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-[#334155] font-bold text-lg">No users found</p>
                <p class="text-sm text-[#94a3b8] mt-1">Click "Add New User" to create your first user.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead style="background: #fafbff;">
                        <tr class="border-b border-[#eef1f8]">
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Name</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Email</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Phone</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Role</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f4f9]">
                        @foreach($users as $user)
                            <tr class="group hover:bg-[#fafbff] transition-all duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full text-xs font-bold text-white shadow-md
                                                    {{ $user->isSuper() ? 'bg-gradient-to-br from-amber-500 to-orange-500 shadow-amber-500/20' : ($user->isAdmin() ? 'bg-gradient-to-br from-purple-500 to-indigo-500 shadow-purple-500/20' : 'bg-gradient-to-br from-slate-400 to-slate-500') }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#0f1419]">{{ $user->name }}</p>
                                            @if($user->description)
                                                <p class="text-xs text-[#94a3b8] mt-0.5 max-w-xs truncate font-medium">{{ $user->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[#475569] font-medium">{{ $user->email ?? '—' }}</td>
                                <td class="px-6 py-4 text-[#475569] font-medium">{{ $user->phone ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if($user->isSuper())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Super Admin
                                        </span>
                                    @elseif($user->isAdmin())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                                            Admin PIC
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 hover:bg-purple-100 border border-purple-200 text-xs font-bold text-purple-700 transition-all duration-200">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        @if(!$user->isSuper())
                                            <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" data-confirm="Delete '{{ $user->name }}'? This cannot be undone."
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 border border-red-200 text-xs font-bold text-red-700 transition-all duration-200">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-[#eef1f8]">{{ $users->links() }}</div>
            @endif
        @endif
    </div>

@endsection