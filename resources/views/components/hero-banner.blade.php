@props([
    'title' => 'Welcome Back',
    'subtitle' => 'Manage your room bookings easily.',
    'label' => 'MyBooking HPD',
])

<div class="hero-banner animate-fade-in-up">

    {{-- Gradient orbs --}}
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>

    {{-- Floating dots --}}
    <div class="hero-dot" style="width: 8px; height: 8px; top: 20%; left: 30%; animation-delay: 0s;"></div>
    <div class="hero-dot" style="width: 6px; height: 6px; top: 60%; left: 15%; animation-delay: 1s;"></div>
    <div class="hero-dot" style="width: 10px; height: 10px; top: 30%; right: 25%; animation-delay: 2s;"></div>
    <div class="hero-dot" style="width: 5px; height: 5px; bottom: 30%; right: 15%; animation-delay: 1.5s;"></div>
    <div class="hero-dot" style="width: 7px; height: 7px; bottom: 50%; left: 45%; animation-delay: 2.5s;"></div>

    {{-- Sparkle stars --}}
    <svg class="hero-sparkle" style="top: 15%; right: 40%; width: 16px; height: 16px;" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/>
    </svg>
    <svg class="hero-sparkle" style="top: 70%; right: 30%; width: 12px; height: 12px; animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/>
    </svg>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-6 items-center">

        {{-- LEFT: Content --}}
        <div class="hero-content">
            <div class="hero-label">
                <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                {{ $label }}
            </div>

            <h1 class="hero-title">{{ $title }}</h1>
            <p class="hero-subtitle">{{ $subtitle }}</p>

            @if(!$slot->isEmpty())
                <div class="mt-6 flex flex-wrap gap-3">
                    {{ $slot }}
                </div>
            @endif
        </div>

        {{-- RIGHT: Illustration --}}
        <div class="hero-illustration">
            <div class="hero-illustration-anim relative">

                <div class="relative flex items-center justify-center" style="width: 180px; height: 180px;">

                    <div class="absolute inset-0 rounded-full" 
                         style="background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.05));
                                border: 2px solid rgba(255, 255, 255, 0.2);
                                backdrop-filter: blur(12px);">
                    </div>

                    <svg class="w-20 h-20 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                    </svg>

                    <div class="absolute -top-2 -right-2 h-14 w-14 rounded-2xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, #fbbf24, #f59e0b);
                                box-shadow: 0 8px 20px -8px rgba(245, 158, 11, 0.6);">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                        </svg>
                    </div>

                    <div class="absolute -bottom-2 -left-2 h-12 w-12 rounded-2xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, #22d3ee, #06b6d4);
                                box-shadow: 0 8px 20px -8px rgba(6, 182, 212, 0.6);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div class="absolute top-1/2 -left-4 h-10 w-10 rounded-xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, #34d399, #10b981);
                                box-shadow: 0 8px 20px -8px rgba(16, 185, 129, 0.6);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>