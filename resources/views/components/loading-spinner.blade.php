@props(['size' => 'md', 'color' => 'blue'])

@php
    $sizeClasses = [
        'sm' => 'h-6 w-6 border-2',
        'md' => 'h-10 w-10 border-4',
        'lg' => 'h-14 w-14 border-4',
        'xl' => 'h-20 w-20 border-4',
    ];
    
    $colorClasses = [
        'blue' => 'border-blue-500',
        'white' => 'border-white',
        'amber' => 'border-amber-500',
        'emerald' => 'border-emerald-500',
        'red' => 'border-red-500',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="flex items-center justify-center {{ $attributes->get('class') }}">
    <div class="{{ $sizeClass }} border-t-transparent rounded-full animate-spin {{ $colorClass }}"></div>
</div>