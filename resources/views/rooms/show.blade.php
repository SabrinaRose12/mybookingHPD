@extends('layouts.app')
@section('title', $room->name)

@section('content')

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex animate-fade-in-up" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('rooms.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold transition-colors">Rooms</a>
            </li>
            <li class="flex items-center">
                <svg class="w-3 h-3 mx-1 text-[#cbd2e0]" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="ml-1 text-[#475569] font-medium">{{ $room->name }}</span>
            </li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 animate-fade-in-up">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-3xl font-extrabold text-[#0f1419] tracking-tight">{{ $room->name }}</h1>
                @php
                    $status = $room->current_status;
                    $statusConfig = [
                        'available' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'label' => 'Available'],
                        'booked'    => ['bg' => 'bg-red-50',     'text' => 'text-red-700',     'border' => 'border-red-200',     'dot' => 'bg-red-500',     'label' => 'Booked'],
                        'pending'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'dot' => 'bg-amber-500',   'label' => 'Pending'],
                    ];
                    $sc = $statusConfig[$status];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }} border {{ $sc['border'] }}">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 {{ $sc['dot'] }}"></span>
                    </span>
                    {{ $sc['label'] }}
                </span>
            </div>
            @if($room->building)
                <p class="mt-2 text-[#64748b] flex items-center gap-1.5 font-medium">
                    <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ $room->building }}
                </p>
            @endif
        </div>
        <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}"
           class="btn-modern btn-primary self-start md:self-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Book This Room
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Image Gallery --}}
            @if($room->images && count($room->images) > 0)
                <div class="space-y-4 modern-card p-3 animate-fade-in-up">
                    <div id="main-image-container" class="w-full h-64 md:h-96 rounded-xl bg-[#fafbff] flex items-center justify-center border border-[#eef1f8] overflow-hidden relative cursor-zoom-in group/main">
                        <img id="main-room-image" src="{{ $room->imageUrl($room->images[0]) }}" alt="{{ $room->name }}" class="w-full h-full object-cover transition-opacity duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f1419]/40 to-transparent opacity-0 group-hover/main:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                            <span class="flex items-center gap-2 bg-white/95 text-[#0f1419] text-sm font-bold px-4 py-2.5 rounded-xl backdrop-blur-sm transform translate-y-2 group-hover/main:translate-y-0 transition-all duration-300 shadow-xl">
                                <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                </svg>
                                View Fullscreen
                            </span>
                        </div>
                    </div>
                    @if(count($room->images) > 1)
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            @foreach($room->images as $img)
                                <button type="button" 
                                        onmouseover="document.getElementById('main-room-image').src='{{ $room->imageUrl($img) }}'"
                                        onclick="document.getElementById('main-room-image').src='{{ $room->imageUrl($img) }}'"
                                        class="thumbnail-btn flex-shrink-0 w-32 h-24 md:w-40 md:h-28 rounded-xl overflow-hidden border-2 border-[#eef1f8] hover:border-purple-500 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500/30">
                                    <img src="{{ $room->imageUrl($img) }}" alt="{{ $room->name }} view" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="w-full h-64 md:h-96 rounded-2xl bg-gradient-to-br from-purple-500/10 to-indigo-500/10 border border-purple-500/20 flex items-center justify-center overflow-hidden relative animate-fade-in-up">
                    <svg class="h-20 w-20 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif

            {{-- Overview --}}
            <div class="modern-card p-6 md:p-8 animate-fade-in-up animate-fade-in-up-delay-1">
                <h3 class="text-xl font-bold text-[#0f1419] mb-5 flex items-center gap-2">
                    <div class="icon-container h-9 w-9" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                        <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Overview
                </h3>
                
                <div class="flex flex-wrap gap-3 mb-6">
                    <div class="flex items-center gap-2.5 bg-[#fafbff] px-4 py-2.5 rounded-xl border border-[#e2e7f0]">
                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-[#334155] font-bold text-sm">Capacity: {{ $room->capacity }} people</span>
                    </div>
                </div>

                <p class="text-[#475569] leading-relaxed">{{ $room->description ?: 'No description provided for this room.' }}</p>

                @if($room->facilities && count($room->facilities) > 0)
                    <div class="mt-8 pt-6 border-t border-[#eef1f8]">
                        <h4 class="text-xs uppercase tracking-widest font-bold text-[#94a3b8] mb-4">Facilities</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($room->facilities as $facility)
                                <span class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-xs font-semibold border border-purple-200">
                                    {{ $facility }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Today's Schedule --}}
        <div class="lg:col-span-1 space-y-8">
            <div class="modern-card p-6 animate-fade-in-up animate-fade-in-up-delay-2">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-[#0f1419] flex items-center gap-2">
                        <div class="icon-container h-8 w-8" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                            <svg class="h-3.5 w-3.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        Today's Schedule
                    </h3>
                </div>
                <p class="text-xs text-[#94a3b8] font-semibold mb-5 uppercase tracking-widest">{{ now()->format('l, j M Y') }}</p>

                @if($todayBookings->isEmpty())
                    <div class="text-center py-8">
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 border border-emerald-200 mb-3">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-[#334155] font-bold text-sm">No bookings today</p>
                        <p class="text-[#94a3b8] text-xs mt-1 font-medium">This room is completely available.</p>
                    </div>
                @else
                    <div class="relative border-l-2 border-[#eef1f8] ml-2 pl-5 space-y-4">
                        @foreach($todayBookings as $booking)
                            <div class="relative">
                                <div class="absolute -left-[27px] top-3 h-3 w-3 rounded-full border-2 border-white {{ $booking->status === 'approved' ? 'bg-red-500' : 'bg-amber-500' }} shadow-md"></div>
                                <div class="bg-white rounded-xl p-4 border border-[#eef1f8] border-l-4 {{ $booking->status === 'approved' ? 'border-l-red-500' : 'border-l-amber-500' }} shadow-sm">
                                    <div class="flex justify-between items-start mb-1.5">
                                        <div class="font-bold text-[#0f1419] text-sm">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</div>
                                        <span class="text-[10px] uppercase font-bold tracking-wider {{ $booking->status === 'approved' ? 'text-red-600' : 'text-amber-600' }}">{{ $booking->status }}</span>
                                    </div>
                                    <p class="text-xs text-[#64748b] truncate font-medium">{{ $booking->purpose }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Fullscreen Modal --}}
    @if($room->images && count($room->images) > 0)
        <div id="fullscreen-modal" class="fixed inset-0 z-[100] hidden bg-[#0f1419]/95 backdrop-blur-md flex-col items-center justify-center p-4">
            <button id="close-modal" type="button" class="absolute top-6 right-6 text-white/70 hover:text-white p-3 bg-white/10 hover:bg-white/20 rounded-full border border-white/20 transition-all z-50">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="relative w-full max-w-5xl max-h-[85vh] flex items-center justify-center">
                <img id="modal-image" src="" alt="Fullscreen view" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
                
                @if(count($room->images) > 1)
                    <button id="prev-modal-image" type="button" class="absolute left-4 md:-left-20 text-white/70 hover:text-white p-3.5 bg-white/10 hover:bg-white/20 rounded-full border border-white/20 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button id="next-modal-image" type="button" class="absolute right-4 md:-right-20 text-white/70 hover:text-white p-3.5 bg-white/10 hover:bg-white/20 rounded-full border border-white/20 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @endif
            </div>
            
            <div class="mt-6 text-center text-white/80 text-sm font-semibold bg-white/10 border border-white/20 px-4 py-2 rounded-full backdrop-blur-sm">
                <span id="modal-caption-index" class="text-white font-bold">1</span> / {{ count($room->images) }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const images = @json(array_map(fn($img) => $room->imageUrl($img), $room->images));
                let currentIdx = 0;
                const mainImageContainer = document.getElementById('main-image-container');
                const mainRoomImage = document.getElementById('main-room-image');
                const fullscreenModal = document.getElementById('fullscreen-modal');
                const modalImage = document.getElementById('modal-image');
                const closeModal = document.getElementById('close-modal');
                const prevBtn = document.getElementById('prev-modal-image');
                const nextBtn = document.getElementById('next-modal-image');
                const captionIdx = document.getElementById('modal-caption-index');

                document.querySelectorAll('.thumbnail-btn').forEach((btn, index) => {
                    btn.addEventListener('mouseover', () => { currentIdx = index; });
                    btn.addEventListener('click', () => { currentIdx = index; });
                });

                if (mainImageContainer) mainImageContainer.addEventListener('click', openFullscreen);

                function openFullscreen() {
                    if (images.length === 0) return;
                    updateModalImage();
                    fullscreenModal.classList.remove('hidden');
                    fullscreenModal.classList.add('flex');
                    document.body.classList.add('overflow-hidden');
                }
                function closeFullscreen() {
                    fullscreenModal.classList.add('hidden');
                    fullscreenModal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }
                function updateModalImage() {
                    modalImage.classList.add('opacity-0');
                    setTimeout(() => {
                        modalImage.src = images[currentIdx];
                        modalImage.classList.remove('opacity-0');
                    }, 100);
                    if (captionIdx) captionIdx.textContent = currentIdx + 1;
                    if (mainRoomImage) mainRoomImage.src = images[currentIdx];
                }
                if (closeModal) closeModal.addEventListener('click', closeFullscreen);
                if (fullscreenModal) fullscreenModal.addEventListener('click', (e) => { if (e.target === fullscreenModal) closeFullscreen(); });
                document.addEventListener('keydown', (e) => {
                    if (!fullscreenModal.classList.contains('hidden')) {
                        if (e.key === 'Escape') closeFullscreen();
                        else if (e.key === 'ArrowLeft' && images.length > 1) prevImage();
                        else if (e.key === 'ArrowRight' && images.length > 1) nextImage();
                    }
                });
                function prevImage() { currentIdx = (currentIdx - 1 + images.length) % images.length; updateModalImage(); }
                function nextImage() { currentIdx = (currentIdx + 1) % images.length; updateModalImage(); }
                if (prevBtn) prevBtn.addEventListener('click', prevImage);
                if (nextBtn) nextBtn.addEventListener('click', nextImage);
            });
        </script>
    @endif

@endsection