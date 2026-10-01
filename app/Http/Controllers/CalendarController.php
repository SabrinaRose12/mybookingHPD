<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Display the calendar view.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get rooms based on user role
        if ($user->isSuper()) {
            $rooms = Room::where('is_active', true)->orderBy('name')->get();
        } elseif ($user->isAdmin()) {
            $assignedRoomIds = $user->assigned_rooms ?? [];
            $rooms = Room::whereIn('id', $assignedRoomIds)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } else {
            $rooms = Room::where('is_active', true)->orderBy('name')->get();
        }

        return view('calendar.index', compact('rooms'));
    }

    /**
     * Get bookings for a specific date or date range (API).
     */
    public function getBookings(Request $request)
    {
        $user = Auth::user();
        
        // Range mode — for monthly calendar
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            ]);
            
            $query = Booking::with(['user', 'room'])
                ->whereBetween('start_time', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ])
                ->whereIn('status', ['approved', 'pending']);
            
            // Filter by role
            if ($user->isAdmin() && !$user->isSuper()) {
                $assignedRoomIds = $user->assigned_rooms ?? [];
                $query->whereIn('room_id', $assignedRoomIds);
            }
            
            $bookings = $query->get();
            
            // Group by date
            $groupedByDate = [];
            foreach ($bookings as $booking) {
                $dateKey = $booking->start_time->format('Y-m-d');
                if (!isset($groupedByDate[$dateKey])) {
                    $groupedByDate[$dateKey] = [];
                }
                $groupedByDate[$dateKey][] = [
                    'id' => $booking->id,
                    'room_name' => $booking->room->name,
                    'status' => $booking->status,
                ];
            }
            
            return response()->json([
                'dates' => $groupedByDate,
            ]);
        }
        
        // Single date mode — for showing bookings on a date
        $request->validate([
            'date' => ['required', 'date'],
        ]);
        
        $date = $request->date;
        
        $query = Booking::with(['user', 'room'])
            ->whereDate('start_time', $date)
            ->whereIn('status', ['approved', 'pending'])
            ->orderBy('start_time');
        
        // Filter by role
        if ($user->isAdmin() && !$user->isSuper()) {
            $assignedRoomIds = $user->assigned_rooms ?? [];
            $query->whereIn('room_id', $assignedRoomIds);
        }
        
        // Filter by room if provided
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }
        
        $bookings = $query->get()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'date' => $booking->start_time->format('Y-m-d'),
                'room_name' => $booking->room->name,
                'room_building' => $booking->room->building,
                'user_name' => $booking->user->name,
                'start_time' => $booking->start_time->format('g:i A'),
                'end_time' => $booking->end_time->format('g:i A'),
                'purpose' => $booking->purpose,
                'status' => $booking->status,
            ];
        });
        
        return response()->json([
            'date' => $date,
            'bookings' => $bookings,
            'count' => $bookings->count(),
        ]);
    }
}