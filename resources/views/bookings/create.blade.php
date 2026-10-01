@extends('layouts.app')
@section('title', 'Book a Room')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex animate-fade-in-up">
        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 hover:text-purple-700 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Browse Rooms
        </a>
    </nav>

    {{-- Page Header --}}
    <div class="mb-10 animate-fade-in-up">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500/10 to-indigo-500/10 border border-purple-500/20 text-xs font-semibold text-purple-700 mb-4">
            <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
            New Booking
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-[#0f1419]">Book a <span class="text-gradient-blue">Room</span></h1>
        <p class="mt-2 text-sm text-[#64748b]">Fill in the form below to submit a booking request.</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-6 p-5 rounded-2xl bg-red-50 border border-red-200 animate-fade-in-up">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 border border-red-200 flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-red-800 mb-1">Booking Cannot Be Submitted</h3>
                    @foreach($errors->all() as $error)
                        <p class="text-sm text-red-700 leading-relaxed">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Suggested Alternatives --}}
    @if(session('suggestions') && collect(session('suggestions'))->isNotEmpty())
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-6 animate-fade-in-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 border border-emerald-200">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-emerald-800">Available Alternatives</h3>
                    <p class="text-xs text-emerald-600 font-medium mt-0.5">The room you selected is unavailable</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach(session('suggestions') as $suggestion)
                    @php
                        $roomId = is_array($suggestion) ? $suggestion['id'] : $suggestion->id;
                        $roomName = is_array($suggestion) ? $suggestion['name'] : $suggestion->name;
                        $roomCapacity = is_array($suggestion) ? $suggestion['capacity'] : $suggestion->capacity;
                        $roomBuilding = is_array($suggestion) ? ($suggestion['building'] ?? null) : ($suggestion->building ?? null);
                    @endphp
                    <div class="bg-white border border-emerald-200 rounded-xl p-4 cursor-pointer hover:border-emerald-500 transition-all duration-200 group"
                         onclick="document.getElementById('room_id').value = '{{ $roomId }}'; window.scrollTo({top: 0, behavior: 'smooth'});">
                        <h4 class="font-bold text-[#0f1419] group-hover:text-emerald-700 transition-colors">{{ $roomName }}</h4>
                        <p class="text-xs text-[#94a3b8] mt-1 font-medium">{{ $roomCapacity }} seats @if($roomBuilding) • {{ $roomBuilding }}@endif</p>
                        <span class="text-xs font-bold text-emerald-600 mt-3 inline-flex items-center gap-1">
                            Select Room
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-6 items-start">
        <div class="space-y-6">
            {{-- Main Form --}}
            <form action="{{ route('bookings.store') }}" method="POST" id="booking-form"
                  class="modern-card p-6 md:p-8 space-y-6 animate-fade-in-up">
                @csrf

                {{-- Room Selection --}}
                <div>
                    <label for="room_id" class="block text-sm font-bold text-[#334155] mb-2">
                        Select Room <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <select name="room_id" id="room_id" required
                                class="auth-input input-icon-left cursor-pointer appearance-none pr-10 {{ $errors->has('room_id') ? 'is-error' : '' }}">
                            <option value="" disabled {{ old('room_id', $selectedRoom?->id) ? '' : 'selected' }}>— Choose a room —</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $selectedRoom?->id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} ({{ $room->capacity }} seats)@if($room->building) — {{ $room->building }}@endif
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-[#94a3b8]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Date --}}
                <div>
                    <label for="date" class="block text-sm font-bold text-[#334155] mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="date" id="date" name="date"
                               value="{{ old('date', now()->format('Y-m-d')) }}"
                               min="{{ now()->format('Y-m-d') }}"
                               required
                               class="auth-input input-icon-left {{ $errors->has('date') ? 'is-error' : '' }}">
                    </div>
                </div>

                {{-- Time Range --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-bold text-[#334155] mb-2">
                            Start Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="start_time" name="start_time"
                               value="{{ old('start_time', '08:00') }}"
                               required
                               class="auth-input pl-4 pr-4 {{ $errors->has('start_time') ? 'is-error' : '' }}">
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-bold text-[#334155] mb-2">
                            End Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="end_time" name="end_time"
                               value="{{ old('end_time', '10:00') }}"
                               required
                               class="auth-input pl-4 pr-4 {{ $errors->has('end_time') ? 'is-error' : '' }}">
                    </div>
                </div>

                {{-- Mobile Status --}}
                <div id="mobile-status-bar" class="hidden lg:hidden rounded-xl px-4 py-3 text-sm font-bold items-center gap-2 bg-[#fafbff] border border-[#eef1f8]">
                    <span id="mobile-status-dot" class="h-2 w-2 rounded-full flex-shrink-0"></span>
                    <span id="mobile-status-text" class="text-[#334155]"></span>
                </div>

                {{-- Mobile Bottom Sheet Trigger --}}
                <button id="mobile-sheet-trigger" type="button" class="hidden lg:hidden w-full rounded-xl border border-[#e2e7f0] bg-white hover:bg-purple-50 text-sm font-bold text-[#475569] hover:text-purple-700 transition-all duration-200 flex items-center justify-center gap-2 py-3" onclick="openBottomSheet()">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    View schedule & room details
                </button>

                {{-- Purpose --}}
                <div>
                    <label for="purpose" class="block text-sm font-bold text-[#334155] mb-2">
                        Purpose <span class="text-[#94a3b8] font-medium">(optional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <input type="text" id="purpose" name="purpose"
                               value="{{ old('purpose') }}"
                               maxlength="255"
                               placeholder="e.g., Group study, Presentation, Lecture..."
                               class="auth-input input-icon-left">
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex items-start gap-3 rounded-xl bg-purple-50 border border-purple-200 p-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 flex-shrink-0">
                        <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </div>
                    <p class="text-xs text-purple-800 leading-relaxed font-medium">
                        Booking requests are reviewed by an admin. You'll see the status update in your
                        <a href="{{ route('dashboard') }}" class="font-bold underline underline-offset-2 hover:text-purple-900">My Bookings</a> dashboard.
                    </p>
                </div>

                {{-- Submit --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-modern btn-primary flex-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Submit Booking Request
                    </button>
                    <a href="{{ route('rooms.index') }}" class="btn-modern btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

        {{-- Right Column: Reactive Panel --}}
        <aside id="booking-panel" class="hidden lg:flex flex-col gap-4 sticky top-24">
            <div id="panel-empty-state" class="modern-card p-8 text-center flex flex-col items-center justify-center h-[300px]">
                <div class="h-14 w-14 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center mb-3">
                    <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-[#334155]">No room selected yet</p>
                <p class="text-xs text-[#94a3b8] mt-1">Select a room and date to see details.</p>
            </div>

            <div id="panel-loading" class="hidden modern-card p-6 h-[300px] flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-purple-500"></div>
            </div>

            <div id="room-details-card" class="hidden modern-card overflow-hidden">
                <div class="p-5">
                    <h3 class="text-base font-bold text-[#0f1419] mb-4 flex items-center gap-2">
                        <div class="icon-container h-8 w-8" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                            <svg class="h-3.5 w-3.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Room Details
                    </h3>
                    <div id="rd-image-container" class="w-full h-32 bg-[#fafbff] rounded-xl mb-4 overflow-hidden relative flex items-center justify-center border border-[#eef1f8]">
                        <img id="rd-image" src="" alt="Room Image" class="w-full h-full object-cover hidden">
                        <svg id="rd-no-image" class="h-10 w-10 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h4 id="rd-name" class="font-bold text-[#0f1419] text-base"></h4>
                    <p id="rd-location" class="text-xs text-[#94a3b8] mt-0.5 mb-4 font-medium"></p>
                    
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div class="bg-[#fafbff] border border-[#eef1f8] rounded-xl p-3">
                            <p class="text-[10px] text-[#94a3b8] font-bold uppercase tracking-widest mb-1">Capacity</p>
                            <p id="rd-capacity" class="text-sm font-bold text-[#334155]"></p>
                        </div>
                        <div class="bg-[#fafbff] border border-[#eef1f8] rounded-xl p-3">
                            <p class="text-[10px] text-[#94a3b8] font-bold uppercase tracking-widest mb-1">Booking Type</p>
                            <p id="rd-approval" class="text-sm font-bold text-[#334155]"></p>
                        </div>
                    </div>

                    <div id="rd-facilities-container">
                        <p class="text-[10px] text-[#94a3b8] font-bold uppercase tracking-widest mb-2">Facilities</p>
                        <div id="rd-facilities" class="flex flex-wrap gap-1.5"></div>
                    </div>
                </div>
            </div>

            <div id="schedule-card" class="hidden modern-card overflow-hidden flex-col">
                <div class="p-5 border-b border-[#eef1f8]">
                    <h3 class="text-base font-bold text-[#0f1419] flex items-center gap-2">
                        <div class="icon-container h-8 w-8" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                            <svg class="h-3.5 w-3.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        Room Schedule
                    </h3>
                </div>
                
                <div class="p-5 flex-1">
                    <p id="schedule-date" class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-6"></p>
                    <div class="relative flex-1" id="timeline-container" style="min-height: 200px;"></div>
                    <div class="mt-4 pt-4 border-t border-[#eef1f8] flex items-center justify-between text-xs font-bold text-[#94a3b8]">
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500"></span>Approved</div>
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Pending</div>
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Your Selection</div>
                    </div>
                </div>
                
                <div id="desk-status-bar" class="px-5 py-3 border-t border-[#eef1f8] flex items-center gap-2 text-sm font-bold bg-[#fafbff]">
                    <span id="desk-status-dot" class="h-2 w-2 rounded-full flex-shrink-0"></span>
                    <span id="desk-status-text" class="text-[#334155]"></span>
                </div>
            </div>
        </aside>
    </div>

    {{-- Mobile Bottom Sheet --}}
    <div id="bottom-sheet-overlay" class="fixed inset-0 z-[100] hidden lg:hidden bg-[#0f1419]/60 backdrop-blur-sm transition-opacity opacity-0" onclick="closeBottomSheet()"></div>
    <div id="bottom-sheet" class="fixed bottom-0 left-0 right-0 z-[101] hidden lg:hidden bg-white rounded-t-3xl max-h-[85vh] flex-col translate-y-full transition-transform duration-300 border-t border-[#eef1f8]">
        <div class="flex justify-center pt-3 pb-2" onclick="closeBottomSheet()">
            <div class="w-12 h-1.5 rounded-full bg-[#cbd2e0]"></div>
        </div>
        <div class="flex border-b border-[#eef1f8] px-4">
            <button type="button" id="tab-schedule" class="auth-tab active" onclick="switchTab('schedule')">Schedule</button>
            <button type="button" id="tab-details" class="auth-tab" onclick="switchTab('details')">Room Details</button>
        </div>
        <div id="tab-content-schedule" class="flex-1 overflow-y-auto p-4">
            <p id="bs-schedule-date" class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-6 text-center"></p>
            <div id="bs-timeline-container" class="relative" style="min-height: 250px;"></div>
        </div>
        <div id="tab-content-details" class="flex-1 overflow-y-auto p-4 hidden">
            <div id="bs-image-container" class="w-full h-40 bg-[#fafbff] rounded-xl mb-4 overflow-hidden relative flex items-center justify-center border border-[#eef1f8]">
                <img id="bs-image" src="" alt="Room Image" class="w-full h-full object-cover hidden">
                <svg id="bs-no-image" class="h-10 w-10 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h4 id="bs-name" class="font-bold text-[#0f1419] text-lg"></h4>
            <p id="bs-location" class="text-sm text-[#94a3b8] mt-0.5 mb-5 font-medium"></p>
            
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="bg-[#fafbff] border border-[#eef1f8] rounded-xl p-3">
                    <p class="text-[10px] text-[#94a3b8] font-bold uppercase tracking-widest">Capacity</p>
                    <p id="bs-capacity" class="text-sm font-bold text-[#334155]"></p>
                </div>
                <div class="bg-[#fafbff] border border-[#eef1f8] rounded-xl p-3">
                    <p class="text-[10px] text-[#94a3b8] font-bold uppercase tracking-widest">Booking Type</p>
                    <p id="bs-approval" class="text-sm font-bold text-[#334155]"></p>
                </div>
            </div>
            <div id="bs-facilities-container">
                <p class="text-sm font-bold text-[#0f1419] mb-3">Facilities</p>
                <div id="bs-facilities" class="flex flex-wrap gap-2"></div>
            </div>
        </div>
        <div class="p-4 border-t border-[#eef1f8]">
            <button type="button" onclick="closeBottomSheet()" class="auth-btn">Continue Booking</button>
        </div>
    </div>

    @push('scripts')
    <script>
        const roomSelect = document.getElementById('room_id');
        const dateInput = document.getElementById('date');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const form = document.getElementById('booking-form');

        const emptyState = document.getElementById('panel-empty-state');
        const loadingState = document.getElementById('panel-loading');
        const roomDetailsCard = document.getElementById('room-details-card');
        const scheduleCard = document.getElementById('schedule-card');
        
        const mobileStatusBar = document.getElementById('mobile-status-bar');
        const mobileStatusDot = document.getElementById('mobile-status-dot');
        const mobileStatusText = document.getElementById('mobile-status-text');
        const mobileSheetTrigger = document.getElementById('mobile-sheet-trigger');
        const bottomSheet = document.getElementById('bottom-sheet');
        const bottomSheetOverlay = document.getElementById('bottom-sheet-overlay');

        let currentRoom = null;
        let currentSchedule = [];
        
        document.addEventListener('DOMContentLoaded', () => {
            if (roomSelect.value) fetchRoomDetails();
        });

        roomSelect.addEventListener('change', fetchRoomDetails);
        dateInput.addEventListener('change', () => { if (roomSelect.value) fetchSchedule(); });
        
        const updateTimeline = () => { if (roomSelect.value && dateInput.value) renderSchedule(); };
        startTimeInput.addEventListener('change', updateTimeline);
        endTimeInput.addEventListener('change', updateTimeline);

        form.addEventListener('submit', (e) => {
            if (startTimeInput.value >= endTimeInput.value) {
                e.preventDefault();
                alert('End time must be after start time.');
            }
        });

        async function fetchRoomDetails() {
            if (!roomSelect.value) return;
            showLoading();
            try {
                const res = await fetch(`/api/rooms/${roomSelect.value}/details`);
                if (!res.ok) throw new Error();
                currentRoom = await res.json();
                renderRoomDetails();
                if (dateInput.value) await fetchSchedule();
                else { hideLoading(); scheduleCard.classList.add('hidden'); roomDetailsCard.classList.remove('hidden'); }
            } catch (error) { showEmptyState(); }
        }

        async function fetchSchedule() {
            if (!roomSelect.value || !dateInput.value) return;
            try {
                const res = await fetch(`/api/rooms/${roomSelect.value}/schedule?date=${dateInput.value}`);
                currentSchedule = (await res.json()).bookings;
                renderSchedule();
                hideLoading();
                roomDetailsCard.classList.remove('hidden');
                scheduleCard.classList.remove('hidden');
                mobileSheetTrigger.classList.remove('hidden');
                mobileSheetTrigger.classList.add('flex');
            } catch (error) { console.error(error); }
        }

        function renderRoomDetails() {
            const data = currentRoom;
            if (!data) return;
            document.getElementById('rd-name').textContent = data.name;
            document.getElementById('rd-location').textContent = data.building || 'No Building Information';
            document.getElementById('rd-capacity').textContent = data.capacity + ' seats';
            document.getElementById('rd-approval').textContent = data.approval_type;
            
            const rdImg = document.getElementById('rd-image'), rdNoImg = document.getElementById('rd-no-image');
            if (data.image_url) { rdImg.src = data.image_url; rdImg.classList.remove('hidden'); rdNoImg.classList.add('hidden'); }
            else { rdImg.classList.add('hidden'); rdNoImg.classList.remove('hidden'); }

            const rdFac = document.getElementById('rd-facilities'), rdFacCont = document.getElementById('rd-facilities-container');
            if (data.facilities?.length > 0) {
                rdFacCont.classList.remove('hidden');
                rdFac.innerHTML = data.facilities.map(f => `<span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-lg border border-purple-200">${f}</span>`).join('');
            } else rdFacCont.classList.add('hidden');

            document.getElementById('bs-name').textContent = data.name;
            document.getElementById('bs-location').textContent = data.building || 'No Building Information';
            document.getElementById('bs-capacity').textContent = data.capacity + ' seats';
            document.getElementById('bs-approval').textContent = data.approval_type;
            
            const bsImg = document.getElementById('bs-image'), bsNoImg = document.getElementById('bs-no-image');
            if (data.image_url) { bsImg.src = data.image_url; bsImg.classList.remove('hidden'); bsNoImg.classList.add('hidden'); }
            else { bsImg.classList.add('hidden'); bsNoImg.classList.remove('hidden'); }

            const bsFac = document.getElementById('bs-facilities'), bsFacCont = document.getElementById('bs-facilities-container');
            if (data.facilities?.length > 0) {
                bsFacCont.classList.remove('hidden');
                bsFac.innerHTML = data.facilities.map(f => `<span class="px-3 py-1.5 bg-purple-50 border border-purple-200 text-purple-700 text-xs font-semibold rounded-lg">${f}</span>`).join('');
            } else bsFacCont.classList.add('hidden');
        }

        function renderSchedule() {
            const deskContainer = document.getElementById('timeline-container');
            const bsContainer = document.getElementById('bs-timeline-container');
            const dateStr = new Date(dateInput.value).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('schedule-date').textContent = dateStr;
            document.getElementById('bs-schedule-date').textContent = dateStr;
            
            const startHour = 7, endHour = 21, totalMinutes = (endHour - startHour) * 60;
            const toMin = (t) => { const [h, m] = t.split(':').map(Number); return (h - startHour) * 60 + m; };
            const getStyle = (s, e) => {
                const sM = Math.max(0, toMin(s)), eM = Math.min(totalMinutes, toMin(e));
                return `left: ${(sM / totalMinutes) * 100}%; width: ${((eM - sM) / totalMinutes) * 100}%;`;
            };

            let html = '';
            for(let h = startHour; h <= endHour; h += 2) {
                const pct = ((h - startHour) * 60 / totalMinutes) * 100;
                html += `<div class="absolute top-0 bottom-0 border-l border-[#e2e7f0] z-0" style="left: ${pct}%;"><span class="absolute -top-5 -left-3 text-[10px] font-bold text-[#94a3b8]">${h}:00</span></div>`;
            }
            html += `<div class="absolute top-6 bottom-0 left-0 right-0 bg-[#fafbff] rounded-lg border border-[#eef1f8] z-0"></div>`;

            let hasApprovedConflict = false, hasPendingConflict = false;
            const selStart = startTimeInput.value, selEnd = endTimeInput.value;

            currentSchedule.forEach(b => {
                const style = getStyle(b.start, b.end);
                let bg = b.status === 'approved' ? 'bg-red-500/90 border-red-500' : 'bg-amber-500/80 border-amber-500';
                let badge = b.status === 'approved' ? 'bg-red-600' : 'bg-amber-600';
                let text = b.status === 'approved' ? 'Approved' : 'Pending';
                
                if (selStart && selEnd && selStart < selEnd && toMin(b.start) < toMin(selEnd) && toMin(b.end) > toMin(selStart)) {
                    if (b.status === 'approved') hasApprovedConflict = true;
                    if (b.status === 'pending') hasPendingConflict = true;
                }

                html += `<div class="absolute top-6 bottom-2 border rounded-lg shadow-sm z-10 flex flex-col justify-between overflow-hidden ${bg} transition-all hover:z-20 hover:-translate-y-0.5" style="${style}">
                    <div class="p-1.5"><span class="text-[10px] font-bold text-white whitespace-nowrap overflow-hidden text-ellipsis px-1 drop-shadow-md">Booked</span></div>
                    <div class="px-1.5 pb-1.5 text-right"><span class="${badge} text-white text-[9px] font-bold px-1.5 py-0.5 rounded">${text}</span></div>
                </div>`;
            });

            if (selStart && selEnd && selStart < selEnd) {
                html += `<div class="absolute top-6 bottom-2 rounded-lg flex flex-col justify-between overflow-hidden bg-purple-500/90 border-2 border-purple-400 z-20 shadow-lg" style="${getStyle(selStart, selEnd)}">
                    <div class="p-1.5"><span class="text-[10px] font-bold text-white block drop-shadow-md">Your Selection</span><span class="text-[9px] font-medium text-purple-100 block">${selStart}-${selEnd}</span></div>
                </div>`;
                updateStatusUI(hasApprovedConflict, hasPendingConflict, selStart, selEnd);
            } else hideStatusUI();

            deskContainer.innerHTML = html;
            bsContainer.innerHTML = html;
        }

        function updateStatusUI(approvedConflict, pendingConflict, start, end) {
            let text, dotColor, barColor;
            if (approvedConflict) { text = 'Slot not available — already booked'; dotColor = 'bg-red-500'; barColor = 'border-red-200 bg-red-50 text-red-700'; }
            else if (pendingConflict) { text = 'Available, but there are pending requests'; dotColor = 'bg-amber-500'; barColor = 'border-amber-200 bg-amber-50 text-amber-700'; }
            else { text = `Slot ${start}–${end} available · ${currentRoom?.capacity || ''} seats`; dotColor = 'bg-emerald-500'; barColor = 'border-emerald-200 bg-emerald-50 text-emerald-700'; }

            mobileStatusBar.classList.remove('hidden'); mobileStatusBar.classList.add('flex');
            document.getElementById('desk-status-text').textContent = text;
            document.getElementById('desk-status-dot').className = `h-2 w-2 rounded-full flex-shrink-0 ${dotColor}`;
            document.getElementById('desk-status-bar').className = `px-5 py-3 border-t flex items-center gap-2 text-sm font-bold rounded-b-2xl ${barColor}`;
            mobileStatusText.textContent = text;
            mobileStatusDot.className = `h-2 w-2 rounded-full flex-shrink-0 ${dotColor}`;
            mobileStatusBar.className = `lg:hidden rounded-xl px-4 py-3 text-sm font-bold flex items-center gap-2 ${barColor}`;
        }

        function hideStatusUI() {
            document.getElementById('desk-status-bar').className = 'hidden';
            mobileStatusBar.classList.add('hidden');
            mobileStatusBar.classList.remove('flex');
        }

        function showLoading() { emptyState.classList.add('hidden'); roomDetailsCard.classList.add('hidden'); scheduleCard.classList.add('hidden'); loadingState.classList.remove('hidden'); loadingState.classList.add('flex'); }
        function hideLoading() { loadingState.classList.add('hidden'); loadingState.classList.remove('flex'); }
        function showEmptyState() { hideLoading(); roomDetailsCard.classList.add('hidden'); scheduleCard.classList.add('hidden'); emptyState.classList.remove('hidden'); emptyState.classList.add('flex'); mobileSheetTrigger.classList.add('hidden'); mobileSheetTrigger.classList.remove('flex'); hideStatusUI(); }

        window.openBottomSheet = () => { bottomSheetOverlay.classList.remove('hidden'); bottomSheet.classList.remove('hidden'); setTimeout(() => { bottomSheetOverlay.classList.remove('opacity-0'); bottomSheet.classList.remove('translate-y-full'); }, 10); };
        window.closeBottomSheet = () => { bottomSheetOverlay.classList.add('opacity-0'); bottomSheet.classList.add('translate-y-full'); setTimeout(() => { bottomSheetOverlay.classList.add('hidden'); bottomSheet.classList.add('hidden'); }, 300); };
        window.switchTab = (tab) => {
            const ts = document.getElementById('tab-schedule'), td = document.getElementById('tab-details');
            const cs = document.getElementById('tab-content-schedule'), cd = document.getElementById('tab-content-details');
            if (tab === 'schedule') { ts.classList.add('active'); td.classList.remove('active'); cs.classList.remove('hidden'); cd.classList.add('hidden'); }
            else { td.classList.add('active'); ts.classList.remove('active'); cd.classList.remove('hidden'); cs.classList.add('hidden'); }
        };
    </script>
    @endpush
@endsection