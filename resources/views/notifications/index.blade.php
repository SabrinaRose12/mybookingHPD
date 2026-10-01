@extends('layouts.app')
@section('title', 'Notifications')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10 animate-fade-in-up">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500/10 to-indigo-500/10 border border-purple-500/20 text-xs font-semibold text-purple-700 mb-4">
                <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                {{ auth()->user()->unreadNotifications()->count() }} unread
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-[#0f1419]">Notifications</h1>
            <p class="mt-2 text-sm text-[#64748b]">Manage and view all your system and booking alerts.</p>
        </div>

        @if(auth()->user()->unreadNotifications()->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-modern btn-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-1.5 mb-6 p-1.5 bg-white border border-[#eef1f8] rounded-2xl w-fit"
         style="box-shadow: 0 1px 3px rgba(15, 20, 25, 0.03);">
        <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200
                  {{ $filter === 'all' ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30' : 'text-[#64748b] hover:text-[#0f1419] hover:bg-[#fafbff]' }}">
            All
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2
                  {{ $filter === 'unread' ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30' : 'text-[#64748b] hover:text-[#0f1419] hover:bg-[#fafbff]' }}">
            Unread
            @if(auth()->user()->unreadNotifications()->count() > 0)
                <span class="inline-flex items-center justify-center h-5 min-w-5 px-1.5 rounded-full text-[10px] font-bold {{ $filter === 'unread' ? 'bg-white/25 text-white' : 'bg-rose-100 text-rose-700' }}">
                    {{ auth()->user()->unreadNotifications()->count() }}
                </span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'read']) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200
                  {{ $filter === 'read' ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30' : 'text-[#64748b] hover:text-[#0f1419] hover:bg-[#fafbff]' }}">
            Read
        </a>
    </div>

    {{-- Notifications List --}}
    <div class="space-y-3 animate-fade-in-up">
        @if($notifications->isEmpty())
            <div class="modern-card p-16 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-purple-50 border border-purple-200 mb-6">
                    <svg class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold text-[#0f1419] mb-2">No notifications</h3>
                <p class="text-sm text-[#94a3b8] font-medium">There are no notifications in this category yet.</p>
            </div>
        @else
            @foreach($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $icon = $notification->data['icon'] ?? '🔔';
                @endphp
                <div class="modern-card p-5 {{ $isUnread ? 'border-l-4 border-l-purple-500' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl flex-shrink-0 text-2xl
                                    {{ $isUnread ? 'bg-gradient-to-br from-purple-500/15 to-indigo-500/10 border border-purple-200' : 'bg-[#fafbff] border border-[#eef1f8]' }}">
                            {{ $icon }}
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 mb-1">
                                <h3 class="text-sm font-extrabold text-[#0f1419] {{ $isUnread ? '' : 'opacity-80' }}">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                <span class="text-xs text-[#94a3b8] flex-shrink-0 font-medium">
                                    {{ $notification->created_at->timezone('Asia/Jakarta')->diffForHumans() }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-[#475569] leading-relaxed {{ $isUnread ? 'font-medium' : '' }}">
                                {{ $notification->data['message'] ?? '' }}
                            </p>

                            <div class="pt-3 flex flex-wrap items-center justify-between gap-3">
                                <span class="text-xs text-[#94a3b8] font-bold">
                                    {{ $notification->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                                </span>

                                <div class="flex items-center gap-2">
                                    @if($isUnread)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-xs font-bold text-purple-600 hover:text-purple-700 px-3 py-1.5 hover:bg-purple-50 rounded-lg transition-all">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif

                                    @if(isset($notification->data['action_url']) && $notification->data['action_url'] !== '#')
                                        <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-[#fafbff] hover:bg-purple-50 text-[#475569] hover:text-purple-700 px-3 py-1.5 rounded-lg border border-[#e2e7f0] hover:border-purple-200 transition-all">
                                            View Details
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($isUnread)
                            <div class="h-2 w-2 rounded-full bg-purple-500 flex-shrink-0 mt-2.5 animate-pulse"></div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if($notifications->hasPages())
        <div class="pt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

@endsection