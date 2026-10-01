@props(['status'])

@php
    $config = match($status) {
        'pending'  => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'dot' => 'bg-amber-500',   'label' => 'Pending',  'pulse' => true],
        'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'label' => 'Approved', 'pulse' => false],
        'rejected' => ['bg' => 'bg-red-50',     'text' => 'text-red-700',     'border' => 'border-red-200',     'dot' => 'bg-red-500',     'label' => 'Rejected', 'pulse' => false],
        default    => ['bg' => 'bg-slate-50',   'text' => 'text-slate-700',   'border' => 'border-slate-200',   'dot' => 'bg-slate-500',   'label' => ucfirst($status), 'pulse' => false],
    };
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold 
             {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
    <span class="relative flex h-1.5 w-1.5">
        @if($config['pulse'])
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $config['dot'] }} opacity-75"></span>
        @endif
        <span class="relative inline-flex rounded-full h-1.5 w-1.5 {{ $config['dot'] }}"></span>
    </span>
    {{ $config['label'] }}
</span>