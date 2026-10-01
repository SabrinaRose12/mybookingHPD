@extends('layouts.app')
@section('title', 'Booking Approvals')

@section('content')

    <x-hero-banner 
        title="Booking Approvals"
        subtitle="Review and manage all booking requests from users. Approve or reject with one click."
        :label="'Admin Panel · ' . now()->format('l, d F Y')">

        <a href="{{ route('calendar.index') }}" class="hero-btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
            </svg>
            View Calendar
        </a>
    </x-hero-banner>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-1" style="color: #f59e0b;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.08));">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    @if($pendingCount > 0)
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                    @endif
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $pendingCount }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-bold uppercase tracking-widest">Pending</p>
            </div>
        </div>

        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-2" style="color: #10b981;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.08));">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $approvedCount }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-bold uppercase tracking-widest">Approved</p>
            </div>
        </div>

        <div class="stat-card animate-fade-in-up animate-fade-in-up-delay-3" style="color: #ef4444;">
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="icon-container h-11 w-11" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.08));">
                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-[#0f1419] tabular-nums tracking-tight">{{ $rejectedCount }}</p>
                <p class="text-xs text-[#94a3b8] mt-1.5 font-bold uppercase tracking-widest">Rejected</p>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-1.5 mb-6 p-1.5 bg-white border border-[#eef1f8] rounded-2xl w-full sm:w-fit overflow-x-auto"
         style="box-shadow: 0 1px 3px rgba(15, 20, 25, 0.03);">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
            <a href="{{ $key == 'all' ? route('admin.bookings.index') : route('admin.bookings.index', ['status' => $key]) }}"
               class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200 whitespace-nowrap flex-shrink-0
                      {{ $status === $key
                          ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                          : 'text-[#64748b] hover:text-[#0f1419] hover:bg-[#fafbff]' }}">
                {{ $label }}
                @if($key === 'pending' && $pendingCount > 0)
                    <span class="ml-1.5 inline-flex items-center justify-center h-4 min-w-4 px-1 rounded-full text-[10px] font-bold {{ $status === $key ? 'bg-white/25 text-white' : 'bg-amber-100 text-amber-700' }}">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- Bookings Table --}}
    <div class="modern-card overflow-hidden animate-fade-in-up">

        @if($bookings->isEmpty())
            <div class="p-16 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-purple-50 border border-purple-200 mb-6">
                    <svg class="h-10 w-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <p class="text-[#334155] font-bold text-lg">No booking records found</p>
                <p class="text-sm text-[#94a3b8] mt-1">Try adjusting filters or check back later.</p>
            </div>
        @else
            <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 z-10" style="background: #fafbff;">
                        <tr class="border-b border-[#eef1f8]">
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">#</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">User</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Space</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Date & Time</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Purpose</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94a3b8] uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f4f9]">
                        @foreach($bookings as $booking)
                            <tr class="group hover:bg-[#fafbff] transition-all duration-150 {{ $booking->isPending() ? 'bg-amber-50/30' : '' }}">
                                <td class="px-6 py-5">
                                    <span class="text-xs font-mono font-bold text-[#94a3b8] bg-[#f1f4f9] px-2 py-1 rounded-md">#{{ $booking->id }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 text-xs font-bold text-white shadow-md shadow-purple-500/20">
                                            {{ substr($booking->user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-[#0f1419] text-sm">{{ $booking->user->name }}</p>
                                            <p class="text-xs text-[#94a3b8] truncate max-w-[160px] font-medium">{{ $booking->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="font-bold text-[#0f1419] text-sm">{{ $booking->room->name }}</p>
                                    @if($booking->room->building)
                                        <p class="text-xs text-[#94a3b8] mt-0.5 font-medium">{{ $booking->room->building }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-[#334155] font-semibold whitespace-nowrap">{{ $booking->start_time->format('j M Y') }}</p>
                                    <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-[#f1f4f9] text-xs text-[#64748b] font-bold">
                                        <svg class="h-3 w-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $booking->start_time->format('g:i A') }} – {{ $booking->end_time->format('g:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 max-w-[180px]">
                                    <p class="text-[#475569] truncate font-medium" title="{{ $booking->purpose }}">{{ $booking->purpose ?? '—' }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <x-badge :status="$booking->status" />
                                    @if($booking->notes)
                                        <p class="text-xs text-[#94a3b8] mt-2 max-w-[180px] truncate" title="{{ $booking->notes }}">{{ $booking->notes }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1.5 min-w-[100px]">
                                        <button type="button" onclick="document.getElementById('view-modal-{{ $booking->id }}').classList.remove('hidden')"
                                                class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 hover:bg-purple-100 border border-purple-200 text-xs font-bold text-purple-700 transition-all duration-200">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            View
                                        </button>

                                        @if($booking->isPending())
                                            <button type="button" onclick="document.getElementById('approve-modal-{{ $booking->id }}').classList.remove('hidden')"
                                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold text-emerald-700 transition-all duration-200">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Approve
                                            </button>
                                            <button type="button" onclick="document.getElementById('reject-modal-{{ $booking->id }}').classList.remove('hidden')"
                                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 border border-red-200 text-xs font-bold text-red-700 transition-all duration-200">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Reject
                                            </button>
                                        @endif
                                    </div>

                                    <div id="view-modal-{{ $booking->id }}" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-[#0f1419]/60 backdrop-blur-md" onclick="if(event.target===this) this.classList.add('hidden')">
                                        <div class="bg-white rounded-3xl p-6 shadow-2xl max-w-xl w-full mx-4 animate-scale-in">
                                            <div class="flex items-center gap-3 mb-5 justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="icon-container h-10 w-10" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(99, 102, 241, 0.08));">
                                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-extrabold text-[#0f1419]">Booking Details</h3>
                                                </div>
                                                <x-badge :status="$booking->status" />
                                            </div>

                                            <div class="space-y-4 text-sm">
                                                <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                                                    <p class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-1">Booked By</p>
                                                    <p class="font-bold text-[#0f1419]">{{ $booking->user->name }}</p>
                                                    <p class="text-xs text-[#64748b] mt-0.5">{{ $booking->user->email }}</p>
                                                </div>
                                                <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                                                    <p class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-1">Room</p>
                                                    <p class="font-bold text-[#0f1419]">{{ $booking->room->name }}</p>
                                                </div>
                                                <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                                                    <p class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-1">Date & Time</p>
                                                    <p class="font-bold text-[#0f1419]">{{ $booking->start_time->format('j M Y') }}</p>
                                                    <p class="text-xs text-[#64748b] mt-0.5">{{ $booking->start_time->format('g:i A') }} – {{ $booking->end_time->format('g:i A') }}</p>
                                                </div>
                                                @if($booking->purpose)
                                                    <div class="bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8]">
                                                        <p class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-1">Purpose</p>
                                                        <p class="font-medium text-[#334155]">{{ $booking->purpose }}</p>
                                                    </div>
                                                @endif
                                                @if($booking->notes)
                                                    <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
                                                        <p class="text-xs font-bold text-amber-700 uppercase tracking-widest mb-1">Notes</p>
                                                        <p class="font-medium text-amber-800">{{ $booking->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex justify-end mt-5 pt-5 border-t border-[#eef1f8]">
                                                <button type="button" onclick="document.getElementById('view-modal-{{ $booking->id }}').classList.add('hidden')" class="btn-modern btn-secondary">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Approve Modal --}}
                                    <div id="approve-modal-{{ $booking->id }}" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-[#0f1419]/60 backdrop-blur-md" onclick="if(event.target===this) this.classList.add('hidden')">
                                        <div class="bg-white rounded-3xl p-6 shadow-2xl max-w-lg w-full mx-4 animate-scale-in">
                                            <div class="flex items-center gap-3 mb-5">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 border border-emerald-200">
                                                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-extrabold text-[#0f1419]">Approve Booking</h3>
                                                    <p class="text-xs text-[#64748b] font-medium">{{ $booking->user->name }} · {{ $booking->room->name }}</p>
                                                </div>
                                            </div>

                                            <p class="text-sm text-[#475569] mb-5 p-4 bg-emerald-50 rounded-xl border border-emerald-200">
                                                Approve booking of <strong class="text-emerald-800">{{ $booking->room->name }}</strong> by <strong class="text-emerald-800">{{ $booking->user->name }}</strong>. User will be notified.
                                            </p>

                                            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <div class="mb-5">
                                                    <label class="block text-sm font-bold text-[#334155] mb-2">Approval Notes <span class="text-[#94a3b8] font-medium">(Optional)</span></label>
                                                    <input type="text" name="notes" class="auth-input pl-4 pr-4" placeholder="e.g., Make sure all switches are turned off before leaving.">
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" onclick="document.getElementById('approve-modal-{{ $booking->id }}').classList.add('hidden')" class="btn-modern btn-secondary">Cancel</button>
                                                    <button type="submit" class="btn-modern" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.75rem 1.5rem; font-weight: 700; border-radius: 0.875rem; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);">Approve Booking</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Reject Modal --}}
                                    <div id="reject-modal-{{ $booking->id }}" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-[#0f1419]/60 backdrop-blur-md" onclick="if(event.target===this) this.classList.add('hidden')">
                                        <div class="bg-white rounded-3xl p-6 shadow-2xl max-w-lg w-full mx-4 animate-scale-in">
                                            <div class="flex items-center gap-3 mb-5">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 border border-red-200">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-extrabold text-[#0f1419]">Reject Booking</h3>
                                                    <p class="text-xs text-[#64748b] font-medium">{{ $booking->user->name }} · {{ $booking->room->name }}</p>
                                                </div>
                                            </div>

                                            <p class="text-sm text-[#475569] mb-5 p-4 bg-red-50 rounded-xl border border-red-200">
                                                Provide reason for rejection. This will be visible to the user.
                                            </p>

                                            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <div class="mb-5">
                                                    <label class="block text-sm font-bold text-[#334155] mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                                                    <textarea name="notes" required rows="3" class="auth-input pl-4 pr-4 resize-none" placeholder="e.g., Room is already booked for internal program."></textarea>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" onclick="document.getElementById('reject-modal-{{ $booking->id }}').classList.add('hidden')" class="btn-modern btn-secondary">Cancel</button>
                                                    <button type="submit" class="btn-modern" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.75rem 1.5rem; font-weight: 700; border-radius: 0.875rem; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);">Reject Booking</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-[#eef1f8]">
                    {{ $bookings->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection