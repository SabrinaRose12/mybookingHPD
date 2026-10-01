@props([
    'title' => 'No data found',
    'message' => 'There is nothing to display here yet.',
    'icon' => null,
    'action' => null,
    'actionLabel' => null,
])

<div class="text-center py-16 animate-fade-in-up">
    <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl 
                bg-gradient-to-br from-purple-500/10 to-indigo-500/10 
                border border-purple-500/20 mb-6 animate-float">
        <svg class="h-9 w-9 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                  d="{{ $icon ?? 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5' }}"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-[#0f1419] mb-2">{{ $title }}</h3>
    <p class="text-sm text-[#64748b] max-w-md mx-auto leading-relaxed mb-6">{{ $message }}</p>
    @if($action && $actionLabel)
        <a href="{{ $action }}" class="btn-modern btn-primary inline-flex">
            {{ $actionLabel }}
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    @endif
</div>