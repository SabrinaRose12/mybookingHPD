@extends('layouts.app')
@section('title', 'Browse Rooms')

@section('content')

    {{-- ═══ Hero Banner ═══ --}}
    <x-hero-banner 
        title="Available Rooms"
        subtitle="Browse rooms and book a space for your needs."
        :label="'MyBooking HPD · ' . $rooms->count() . ' rooms available'">

        <a href="{{ route('dashboard') }}" class="hero-btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            My Bookings
        </a>
    </x-hero-banner>

    {{-- Search & Filter --}}
    <form action="{{ route('rooms.index') }}" method="GET"
          class="mb-8 bg-white border border-[#eef1f8] rounded-2xl p-4 flex flex-col sm:flex-row gap-3 animate-fade-in-up"
          style="box-shadow: 0 1px 3px rgba(15, 20, 25, 0.03), 0 8px 24px -4px rgba(124, 58, 237, 0.06);">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search rooms by name or building..."
                   class="form-input pl-11">
        </div>
        <div class="w-full sm:w-48">
            <select name="capacity" class="form-input pl-4 pr-10 appearance-none font-medium cursor-pointer">
                <option value="">Any Capacity</option>
                <option value="10" {{ request('capacity') == '10' ? 'selected' : '' }}>10+ Seats</option>
                <option value="20" {{ request('capacity') == '20' ? 'selected' : '' }}>20+ Seats</option>
                <option value="50" {{ request('capacity') == '50' ? 'selected' : '' }}>50+ Seats</option>
                <option value="100" {{ request('capacity') == '100' ? 'selected' : '' }}>100+ Seats</option>
            </select>
        </div>
        <button type="submit" class="btn-modern btn-primary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Filter
        </button>
        @if(request()->hasAny(['search', 'capacity']))
            <a href="{{ route('rooms.index') }}" class="btn-modern btn-secondary">Clear</a>
        @endif
    </form>

    @if($rooms->isEmpty())
        <div class="modern-card p-16 text-center animate-fade-in-up">
            <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-purple-500/10 to-indigo-500/10 border border-purple-500/20 mb-6 animate-float">
                <svg class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#0f1419] mb-2">No rooms found</h3>
            <p class="text-sm text-[#64748b] mb-6">Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($rooms as $room)
                @php
                    $status = $room->current_status;
                    $statusConfig = [
                        'available' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'label' => 'Available'],
                        'booked'    => ['bg' => 'bg-red-50',     'text' => 'text-red-700',     'border' => 'border-red-200',     'dot' => 'bg-red-500',     'label' => 'Booked'],
                        'pending'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'dot' => 'bg-amber-500',   'label' => 'Pending'],
                    ];
                    $sc = $statusConfig[$status];
                @endphp
                <div class="modern-card group animate-fade-in-up" style="animation-delay: {{ $loop->iteration * 0.06 }}s;">
                    <div class="h-1.5 w-full bg-gradient-to-r from-purple-500 via-indigo-500 to-pink-500 opacity-60 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-start justify-between gap-3 mb-5">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="icon-container h-12 w-12 flex-shrink-0" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                                    <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-[#0f1419] text-base leading-tight truncate">{{ $room->name }}</h3>
                                    @if($room->building)
                                        <p class="text-xs text-[#94a3b8] mt-1 font-medium truncate">{{ $room->building }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $sc['bg'] }} {{ $sc['text'] }} border {{ $sc['border'] }} flex-shrink-0">
                                <span class="relative flex h-1.5 w-1.5">
                                    @if($status === 'pending')
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $sc['dot'] }} opacity-75"></span>
                                    @endif
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 {{ $sc['dot'] }}"></span>
                                </span>
                                {{ $sc['label'] }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2 mb-4">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#fafbff] border border-[#e2e7f0] text-xs font-semibold text-[#475569]">
                                <svg class="h-3.5 w-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                {{ $room->capacity }} seats
                            </div>
                        </div>

                        @if($room->description)
                            <p class="text-sm text-[#64748b] leading-relaxed flex-1 line-clamp-2 mb-4">{{ $room->description }}</p>
                        @else
                            <div class="flex-1"></div>
                        @endif

                        <div class="flex gap-2 mt-5 pt-4 border-t border-[#eef1f8]">
                            <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}"
                               class="flex-1 text-center rounded-xl bg-gradient-to-br from-purple-600 to-indigo-500 hover:from-purple-500 hover:to-indigo-400 py-2.5 text-sm font-bold text-white transition-all duration-200 shadow-lg shadow-purple-600/25 hover:shadow-purple-500/40 hover:-translate-y-0.5 active:translate-y-0">
                                Book Now
                            </a>
                            <a href="{{ route('rooms.show', $room) }}"
                               class="px-4 rounded-xl border border-[#e2e7f0] hover:border-purple-500/50 bg-white hover:bg-purple-50 text-sm font-semibold text-[#475569] hover:text-purple-700 transition-all duration-200 flex items-center hover:-translate-y-0.5">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection