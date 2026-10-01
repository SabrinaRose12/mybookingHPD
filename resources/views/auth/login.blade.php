<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login MyBooking — HPD Management Complex Room Booking System.">
    <title>Login — MyBooking</title>
    <link href="{{ asset('HPD Logo.png') }}" rel="icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- ANIMATED BACKGROUND LAYERS (no circles) --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}

{{-- Soft aurora gradient --}}
<div class="aurora-bg"></div>

{{-- Holographic grid pattern --}}
<div class="holo-grid"></div>

{{-- Floating sparkles --}}
<div id="sparkles-container"></div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- MAIN CONTENT --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}

<div class="auth-page" style="background: transparent;">

    {{-- Floating decorative icons (no circles around them) --}}
    <div class="float-icon" style="top: 12%; left: 8%; animation-delay: 0s;">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
        </svg>
    </div>
    <div class="float-icon" style="top: 22%; right: 10%; animation-delay: 3s;">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <div class="float-icon" style="bottom: 18%; left: 12%; animation-delay: 6s;">
        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
    </div>
    <div class="float-icon" style="bottom: 25%; right: 8%; animation-delay: 9s;">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
        </svg>
    </div>
    <div class="float-icon" style="top: 50%; left: 5%; animation-delay: 4s;">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
        </svg>
    </div>
    <div class="float-icon" style="top: 70%; right: 6%; animation-delay: 7s;">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
        </svg>
    </div>

    {{-- ═══ Main Card Container ═══ --}}
    <div class="w-full max-w-md relative" style="z-index: 10;">

        {{-- Brand with tight spacing --}}
<div class="text-center mb-4 px-4 pt-1">
    <div class="inline-flex items-center justify-center logo-float -mt-2" style="width: 140px; height: 140px;">
        <img src="{{ asset('HPD Logo.png') }}"
             alt="HPD Logo"
             class="w-32 h-32 object-contain logo-glow">
    </div>

    <h1 class="text-4xl font-extrabold tracking-tight mb-1 -mt-2">
        <span class="text-[#0f1419]">MyBooking</span><span class="holo-title">HPD</span>
    </h1>
    <p class="text-sm text-[#64748b] font-medium">Hospital Port Dickson Room Booking System</p>
</div>

        {{-- ═══ Auth Card ═══ --}}
        <div class="holo-glow-border auth-card-entrance">
            <div class="auth-card overflow-hidden">

                <div class="flex border-b border-white/40">
                    <span class="auth-tab active">Welcome Back</span>
                </div>

                <div class="p-8">
                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-5 p-4 rounded-2xl bg-red-50/90 border border-red-200 backdrop-blur-sm flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 border border-red-200 flex-shrink-0">
                                <svg class="h-4 w-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                @foreach ($errors->all() as $error)
                                    <p class="text-xs text-red-700 leading-relaxed font-medium">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mb-5 p-4 rounded-2xl bg-emerald-50/90 border border-emerald-200 backdrop-blur-sm">
                            <p class="text-xs text-emerald-700 font-medium">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="mb-5 p-4 rounded-2xl bg-amber-50/90 border border-amber-200 backdrop-blur-sm flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 border border-amber-200 flex-shrink-0">
                                <svg class="h-4 w-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-xs text-amber-700 leading-relaxed font-medium">{{ session('warning') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-bold text-[#334155] mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                                       class="auth-input input-icon-left {{ $errors->has('email') ? 'is-error' : '' }}"
                                       placeholder="user@moh.gov.my">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-[#334155] mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" id="password" name="password" required autocomplete="current-password"
                                       class="auth-input input-icon-left input-icon-right"
                                       placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password', this)" class="auth-icon-btn absolute inset-y-0 right-0 pr-3.5 flex items-center">
                                    <svg class="h-4 w-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" id="remember" name="remember"
                                       class="h-4 w-4 rounded border-[#cbd2e0] text-purple-600 cursor-pointer accent-purple-600 focus:ring-purple-500/30">
                                <span class="text-sm text-[#475569] font-medium">Remember me</span>
                            </label>
                            <a href="#" class="text-sm auth-link">Forgot?</a>
                        </div>

                        <button type="submit" class="auth-btn mt-2">Sign In</button>
                    </form>

                    @if(app('env') != 'production')
                        <div class="mt-7 pt-6 border-t border-white/40">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-purple-100/90 backdrop-blur-sm">
                                    <svg class="h-3.5 w-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-xs font-bold text-[#475569] uppercase tracking-wider">Demo Accounts</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <button type="button" onclick="fillCredentials('superadmin@moh.gov.my', 'password')" class="auth-demo-btn backdrop-blur-sm">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        <p class="text-[11px] font-bold text-amber-700">Super Admin</p>
                                    </div>
                                    <p class="text-[10px] text-[#94a3b8] truncate font-medium">superadmin@moh.gov.my</p>
                                </button>
                                <button type="button" onclick="fillCredentials('admin.tanjungtuan@moh.gov.my', 'password')" class="auth-demo-btn backdrop-blur-sm">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                                        <p class="text-[11px] font-bold text-purple-700">Admin PIC</p>
                                    </div>
                                    <p class="text-[10px] text-[#94a3b8] truncate font-medium">admin.tanjungtuan@moh.gov.my</p>
                                </button>
                                <button type="button" onclick="fillCredentials('johndoe@moh.gov.my', 'password')" class="auth-demo-btn backdrop-blur-sm">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        <p class="text-[11px] font-bold text-slate-700">User</p>
                                    </div>
                                    <p class="text-[10px] text-[#94a3b8] truncate font-medium">johndoe@moh.gov.my</p>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <p class="auth-footer-text">&copy; {{ date('Y') }} MyBooking · Hospital Port Dickson</p>

    </div>
</div>

<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('.eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    }

    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        document.getElementById('email').focus();
    }

    // ── Generate Small Floating Dots (no glow circles) ──
    (function generateSparkles() {
        const container = document.getElementById('sparkles-container');
        if (!container) return;

        const sparkleCount = 25;

        for (let i = 0; i < sparkleCount; i++) {
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';

            const size = Math.random() * 3 + 2;            // 2-5px small dots
            const left = Math.random() * 100;
            const delay = Math.random() * 50;
            const duration = Math.random() * 30 + 40;      // 40-70s slow

            sparkle.style.width = size + 'px';
            sparkle.style.height = size + 'px';
            sparkle.style.left = left + '%';
            sparkle.style.bottom = '-10px';
            sparkle.style.animationDelay = delay + 's';
            sparkle.style.animationDuration = duration + 's';

            // Subtle colors, no glow
            const colors = [
                'rgba(124, 58, 237, 0.7)',
                'rgba(236, 72, 153, 0.6)',
                'rgba(6, 182, 212, 0.6)',
                'rgba(99, 102, 241, 0.7)'
            ];
            const color = colors[Math.floor(Math.random() * colors.length)];
            sparkle.style.background = color;

            container.appendChild(sparkle);
        }
    })();
</script>
</body>
</html>