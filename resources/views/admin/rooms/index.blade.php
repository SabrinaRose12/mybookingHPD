@extends('layouts.app')
@section('title', 'Manage Rooms')

@section('content')

    @php
        $user = auth()->user();
        $isSuperAdmin = $user->isSuper();
    @endphp

    {{-- ═══ Hero Banner ═══ --}}
    <x-hero-banner 
        :title="'Manage Rooms'"
        subtitle="{{ $isSuperAdmin ? 'Add, edit, and manage all rooms in the system.' : 'View and manage your assigned rooms.' }}"
        :label="($isSuperAdmin ? 'Super Admin' : 'Admin PIC') . ' · ' . now()->format('l, d F Y')">

        @if($isSuperAdmin)
            <a href="{{ route('admin.rooms.create') }}" class="hero-btn">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add New Room
            </a>
        @endif
        <a href="{{ route('calendar.index') }}" class="hero-btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
            </svg>
            View Calendar
        </a>
    </x-hero-banner>

    <div class="modern-card overflow-hidden animate-fade-in-up">
        @if($rooms->isEmpty())
            <div class="p-16 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-purple-50 border border-purple-200 mb-6">
                    <svg class="h-10 w-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                    </svg>
                </div>
                @if($isSuperAdmin)
                    <p class="text-[#334155] font-bold text-lg">No rooms found</p>
                    <p class="text-sm text-[#94a3b8] mt-1">Click "Add New Room" to create your first room.</p>
                @else
                    <p class="text-[#334155] font-bold text-lg">No rooms assigned to you</p>
                    <p class="text-sm text-[#94a3b8] mt-1 max-w-sm mx-auto">Contact Super Admin to assign rooms to you.</p>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead style="background: #fafbff;">
                        <tr class="border-b border-[#eef1f8]">
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Room</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Building</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Capacity</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f4f9]">
                        @foreach($rooms as $room)
                            <tr class="group hover:bg-[#fafbff] transition-all duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500/15 to-indigo-500/10 border border-purple-500/20">
                                            <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#0f1419]">{{ $room->name }}</p>
                                            @if($room->description)
                                                <p class="text-xs text-[#94a3b8] mt-0.5 max-w-xs truncate font-medium">{{ $room->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[#475569] font-medium">{{ $room->building ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#f1f4f9] border border-[#e2e7f0] text-xs font-bold text-[#334155]">
                                        <svg class="h-3.5 w-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                                        </svg>
                                        {{ $room->capacity }} seats
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($room->is_active)
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
                                        <a href="{{ route('admin.rooms.edit', $room) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 hover:bg-purple-100 border border-purple-200 text-xs font-bold text-purple-700 transition-all duration-200">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>

                                        @if($isSuperAdmin)
                                            <form id="delete-room-{{ $room->id }}" action="{{ route('admin.rooms.destroy', $room) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" data-confirm="Delete '{{ $room->name }}'? This cannot be undone."
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

            @if($rooms->hasPages())
                <div class="px-6 py-4 border-t border-[#eef1f8]">{{ $rooms->links() }}</div>
            @endif
        @endif
    </div>

@endsection