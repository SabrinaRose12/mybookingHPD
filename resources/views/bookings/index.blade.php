@extends('layouts.app')
@section('title', 'My Bookings')

@section('content')

    {{-- ═══ Hero Banner ═══ --}}
    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
    @endphp

    <x-hero-banner 
        :title="$greeting . ', ' . explode(' ', auth()->user()->name)[0] . '!'"
        subtitle="Manage your bookings and book new rooms with ease. Everything you need in one place."
        :label="'MyBooking HPD · ' . now()->format('l, d F Y')">

        <a href="{{ route('bookings.create') }}" class="hero-btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Book New Room
        </a>
        <a href="{{ route('rooms.index') }}" class="hero-btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Browse Rooms
        </a>
    </x-hero-banner>

    {{-- ── Summary Stats ── --}}
    @php
        $total    = $bookings->total();
        $pending  = $bookings->getCollection()->filter(fn($b) => $b->status === 'pending')->count();
        $approved = $bookings->getCollection()->filter(fn($b) => $b->status === 'approved')->count();
        $rejected = $bookings->getCollection()->filter(fn($b) => $b->status === 'rejected')->count();
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        {{-- Total --}}
        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-1" style="color: #7c3aed;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-purple-600/70 uppercase tracking-widest">Total</span>
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $total }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-medium">Bookings</p>
            </div>
        </div>

        {{-- Pending --}}
        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-2" style="color: #f59e0b;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.08));">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    @if($pending > 0)
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                    @endif
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $pending }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-medium">Pending</p>
            </div>
        </div>

        {{-- Approved --}}
        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-3" style="color: #10b981;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.08));">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $approved }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-medium">Approved</p>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-4" style="color: #ef4444;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.08));">
                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $rejected }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-medium">Rejected</p>
            </div>
        </div>
    </div>

    @if($bookings->isEmpty())
        {{-- Empty State --}}
        <div class="modern-card p-16 text-center animate-fade-in-up">
            <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-purple-500/10 to-indigo-500/10 border border-purple-500/20 mb-6 animate-float">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#0f1419] mb-2">No bookings yet</h3>
            <p class="text-sm text-[#64748b] mb-8 max-w-md mx-auto leading-relaxed">
                You haven't made any room bookings yet. Start by exploring available rooms and book your first one!
            </p>
            <a href="{{ route('rooms.index') }}" class="btn-modern btn-primary inline-flex">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Browse Rooms
            </a>
        </div>
    @else
        {{-- Bookings List --}}
        <div class="modern-card overflow-hidden animate-fade-in-up">

            <div class="px-7 py-5 border-b border-[#eef1f8] flex items-center justify-between"
                 style="background: linear-gradient(180deg, #fafbff 0%, #ffffff 100%);">
                <div class="flex items-center gap-3">
                    <div class="icon-container h-10 w-10" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                        <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0f1419]">Booking History</p>
                        <p class="text-xs text-[#94a3b8] mt-0.5">{{ $bookings->total() }} total bookings</p>
                    </div>
                </div>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#eef1f8]" style="background: #fafbff;">
                            <th class="px-7 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Room</th>
                            <th class="px-7 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Date</th>
                            <th class="px-7 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Time</th>
                            <th class="px-7 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Purpose</th>
                            <th class="px-7 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Status</th>
                            <th class="px-7 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f4f9]">
                        @foreach($bookings as $booking)
                            <tr class="group hover:bg-[#fafbff] transition-all duration-200 {{ $booking->isPending() ? 'bg-amber-50/30' : '' }}">
                                <td class="px-7 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500/15 to-indigo-500/10 border border-purple-500/20 group-hover:from-purple-500/25 group-hover:to-indigo-500/15 group-hover:border-purple-500/40 transition-all duration-300">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#0f1419]">{{ $booking->room->name }}</p>
                                            @if($booking->room->building)
                                                <p class="text-xs text-[#94a3b8] mt-0.5 font-medium">{{ $booking->room->building }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-7 py-5">
                                    <p class="text-[#334155] font-semibold whitespace-nowrap">{{ $booking->start_time->format('D, j M Y') }}</p>
                                </td>

                                <td class="px-7 py-5">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#f1f4f9] border border-[#e2e7f0] text-xs font-semibold text-[#475569] whitespace-nowrap">
                                        <svg class="h-3.5 w-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $booking->start_time->format('g:i A') }} – {{ $booking->end_time->format('g:i A') }}
                                    </div>
                                </td>

                                <td class="px-7 py-5 text-[#475569] max-w-[220px]">
                                    <p class="truncate font-medium" title="{{ $booking->purpose }}">{{ $booking->purpose ?? '—' }}</p>
                                </td>

                                <td class="px-7 py-5">
                                    <x-badge :status="$booking->status" />
                                    @if($booking->notes)
                                        <p class="text-xs text-[#94a3b8] mt-2 max-w-[180px] truncate" title="{{ $booking->notes }}">
                                            {{ $booking->notes }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-7 py-5">
                                    @if($booking->isPending())
                                        <form id="cancel-form-{{ $booking->id }}" action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    data-confirm="Cancel this booking request? This action cannot be undone."
                                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-white bg-red-50 hover:bg-red-500 border border-red-200 hover:border-red-500 px-3.5 py-2 rounded-xl transition-all duration-200">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-[#cbd2e0]">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden divide-y divide-[#f1f4f9]">
                @foreach($bookings as $booking)
                    <div class="p-5 flex flex-col gap-4 {{ $booking->isPending() ? 'bg-amber-50/30' : '' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500/15 to-indigo-500/10 border border-purple-500/20 flex-shrink-0">
                                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#0f1419] text-base">{{ $booking->room->name }}</h4>
                                    @if($booking->room->building)
                                        <p class="text-xs text-[#94a3b8] mt-0.5 font-medium">{{ $booking->room->building }}</p>
                                    @endif
                                </div>
                            </div>
                            <x-badge :status="$booking->status" />
                        </div>

                        <div class="space-y-2.5">
                            <div class="flex flex-wrap gap-2 text-xs">
                                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-[#f1f4f9] border border-[#e2e7f0] rounded-lg text-[#475569] font-semibold">
                                    <svg class="h-3.5 w-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                                    </svg>
                                    {{ $booking->start_time->format('D, j M Y') }}
                                </div>
                                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-[#f1f4f9] border border-[#e2e7f0] rounded-lg text-[#475569] font-semibold">
                                    <svg class="h-3.5 w-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $booking->start_time->format('g:i A') }} – {{ $booking->end_time->format('g:i A') }}
                                </div>
                            </div>

                            @if($booking->purpose)
                                <div class="text-xs text-[#475569] bg-[#fafbff] p-3 rounded-xl border border-[#eef1f8]">
                                    <span class="font-bold text-[#334155]">Purpose:</span>
                                    <span>{{ $booking->purpose }}</span>
                                </div>
                            @endif

                            @if($booking->notes)
                                <div class="text-xs text-amber-700 bg-amber-50 border border-amber-200 p-3 rounded-xl">
                                    <span class="font-bold block mb-0.5">Admin Notes:</span>
                                    {{ $booking->notes }}
                                </div>
                            @endif
                        </div>

                        @if($booking->isPending())
                            <div class="border-t border-[#f1f4f9] pt-3">
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            data-confirm="Cancel this booking request?"
                                            class="w-full flex items-center justify-center gap-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl py-2.5 transition-all">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Cancel Request
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($bookings->hasPages())
                <div class="px-7 py-5 border-t border-[#eef1f8]">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    @endif

@endsection