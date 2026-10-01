<?php

namespace App\Http\Controllers\Admin;

use App\Events\RealtimeNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingRejectedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display all bookings with optional status filter.
     * Filter by assigned rooms for non-super admins.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->query('status', 'all');
        
        $query = Booking::with(['user', 'room'])->orderByDesc('created_at');

        // If user is admin (not super), filter by assigned rooms only
        if ($user->isAdmin() && !$user->isSuper()) {
            $assignedRoomIds = $user->assigned_rooms ?? [];
            
            if (empty($assignedRoomIds)) {
                // Admin has no assigned rooms - show empty state
                $bookings = $query->whereRaw('1 = 0')->paginate(10)->withQueryString();
                $pendingCount = 0;
                $approvedCount = 0;
                $rejectedCount = 0;
                
                return view('admin.bookings.index', compact(
                    'bookings', 'status', 'pendingCount', 'approvedCount', 'rejectedCount'
                ));
            }
            
            $query->whereIn('room_id', $assignedRoomIds);
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();
        
        // Counts should also be filtered for admin
        $pendingQuery = Booking::where('status', Booking::STATUS_PENDING);
        $approvedQuery = Booking::where('status', Booking::STATUS_APPROVED);
        $rejectedQuery = Booking::where('status', Booking::STATUS_REJECTED);
        
        if ($user->isAdmin() && !$user->isSuper()) {
            $assignedRoomIds = $user->assigned_rooms ?? [];
            if (!empty($assignedRoomIds)) {
                $pendingQuery->whereIn('room_id', $assignedRoomIds);
                $approvedQuery->whereIn('room_id', $assignedRoomIds);
                $rejectedQuery->whereIn('room_id', $assignedRoomIds);
            } else {
                $pendingQuery->whereRaw('1 = 0');
                $approvedQuery->whereRaw('1 = 0');
                $rejectedQuery->whereRaw('1 = 0');
            }
        }
        
        $pendingCount = $pendingQuery->count();
        $approvedCount = $approvedQuery->count();
        $rejectedCount = $rejectedQuery->count();

        return view('admin.bookings.index', compact(
            'bookings', 'status', 'pendingCount', 'approvedCount', 'rejectedCount'
        ));
    }

    /**
     * Approve or reject a booking.
     * Check if admin has permission for this room.
     */
    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user can manage this room
        if (!$user->canManageRoom($booking->room_id)) {
            abort(403, 'You do not have permission to manage bookings for this room.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'notes'  => ['nullable', 'string', 'max:500'],
        ]);

        // Extra conflict check when approving: ensure no other approved booking exists
        if ($validated['status'] === Booking::STATUS_APPROVED) {
            $conflict = Booking::where('room_id', $booking->room_id)
                ->where('id', '!=', $booking->id)
                ->where('status', Booking::STATUS_APPROVED)
                ->where('start_time', '<', $booking->end_time)
                ->where('end_time', '>', $booking->start_time)
                ->exists();

            if ($conflict) {
                return back()->with('error', 'Cannot approve: there is already an approved booking for this room at the same time.');
            }
        }

        $booking->update([
            'status' => $validated['status'],
            'notes'  => $validated['notes'] ?? null,
        ]);

        // Refresh model to get latest status
        $booking->refresh();

        // Dispatch in-app notification AND WebSocket event to the user
        if ($booking->status === Booking::STATUS_APPROVED) {
            $booking->user->notifyNow(new BookingApprovedNotification($booking));

            event(new RealtimeNotificationEvent(
                user: $booking->user,
                title: ' Booking Approved',
                message: "Booking #{$booking->id} for {$booking->room->name} has been APPROVED.",
                actionUrl: route('dashboard', [], false),
                icon: ''
            ));
        } elseif ($booking->status === Booking::STATUS_REJECTED) {
            $booking->user->notifyNow(new BookingRejectedNotification($booking));

            event(new RealtimeNotificationEvent(
                user: $booking->user,
                title: ' Booking Rejected',
                message: "Booking #{$booking->id} for {$booking->room->name} was rejected.",
                actionUrl: route('rooms.index', [], false),
                icon: ''
            ));
        }

        $action = $validated['status'] === Booking::STATUS_APPROVED ? 'approved' : 'rejected';

        return back()->with('success', "Booking #{$booking->id} has been {$action} successfully.");
    }
}