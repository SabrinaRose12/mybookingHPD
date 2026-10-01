@props(['type' => 'success', 'message'])

@php
    $config = match($type) {
        'success' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'icon' => 'text-emerald-600', 'text' => 'text-emerald-800', 'svg' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
        'error'   => ['bg' => 'bg-red-50',     'border' => 'border-red-200',     'icon' => 'text-red-600',     'text' => 'text-red-800',     'svg' => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z'],
        'warning' => ['bg' => 'bg-amber-50',   'border' => 'border-amber-200',   'icon' => 'text-amber-600',   'text' => 'text-amber-800',   'svg' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z'],
        default   => ['bg' => 'bg-blue-50',    'border' => 'border-blue-200',    'icon' => 'text-blue-600',    'text' => 'text-blue-800',    'svg' => 'M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z'],
    };
@endphp

<div data-auto-dismiss
     class="flex items-start gap-3 rounded-2xl border p-4 mb-4 {{ $config['bg'] }} {{ $config['border'] }} shadow-sm">
    <div class="flex h-8 w-8 items-center justify-center rounded-lg {{ $config['bg'] }} border {{ $config['border'] }} flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 {{ $config['icon'] }}">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['svg'] }}" />
        </svg>
    </div>
    <p class="text-sm font-medium {{ $config['text'] }} leading-relaxed pt-1">{{ $message }}</p>
</div>