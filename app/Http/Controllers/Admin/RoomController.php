<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Display all rooms (active and inactive) for admin management.
     * Filter by assigned rooms for non-super admins.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        $query = Room::orderBy('name');
        
        // If user is admin (not super), filter by assigned rooms only
        if ($user->isAdmin() && !$user->isSuper()) {
            $assignedRoomIds = $user->assigned_rooms ?? [];
            
            if (empty($assignedRoomIds)) {
                // Admin has no assigned rooms - show empty state
                $rooms = $query->whereRaw('1 = 0')->paginate(15);
                return view('admin.rooms.index', compact('rooms'));
            }
            
            $query->whereIn('id', $assignedRoomIds);
        }
        
        $rooms = $query->paginate(15);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form to create a new room.
     * ONLY SUPER ADMIN can create rooms.
     */
    public function create(): View
    {
        $user = Auth::user();
        
        // Only Super Admin can create rooms
        if (!$user->isSuper()) {
            abort(403, 'Only Super Admin can create new rooms.');
        }
        
        return view('admin.rooms.create', ['room' => null]);
    }

    /**
     * Store a newly created room.
     * ONLY SUPER ADMIN can create rooms.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Only Super Admin can create rooms
        if (!$user->isSuper()) {
            abort(403, 'Only Super Admin can create new rooms.');
        }
        
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:rooms,name'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'building'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'images.*'    => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('rooms', 'public');
            }
        }
        $validated['images'] = $imagePaths;

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room "' . $validated['name'] . '" has been created successfully.');
    }

    /**
     * Show the form to edit an existing room.
     * Check if admin has permission for this room.
     */
    public function edit(Room $room): View
    {
        $user = Auth::user();
        
        // Check if user can manage this room
        if (!$user->canManageRoom($room->id)) {
            abort(403, 'You do not have permission to edit this room.');
        }
        
        return view('admin.rooms.create', compact('room'));
    }

    /**
     * Update an existing room.
     * Check if admin has permission for this room.
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user can manage this room
        if (!$user->canManageRoom($room->id)) {
            abort(403, 'You do not have permission to update this room.');
        }
        
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:rooms,name,' . $room->id],
            'capacity'    => ['required', 'integer', 'min:1'],
            'building'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'images.*'    => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $imagePaths = $room->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('rooms', 'public');
            }
        }
        $validated['images'] = $imagePaths;

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room "' . $room->name . '" has been updated successfully.');
    }

    /**
     * Delete an individual image from a room.
     * Check if admin has permission for this room.
     */
    public function deleteImage(Room $room, Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user can manage this room
        if (!$user->canManageRoom($room->id)) {
            abort(403, 'You do not have permission to delete images from this room.');
        }
        
        $imagePath = $request->input('image_path');
        $images = $room->images ?? [];

        if (($key = array_search($imagePath, $images)) !== false) {
            unset($images[$key]);

            // Re-index array to prevent JSON object conversion issue
            $room->update(['images' => array_values($images)]);

            // Delete file from storage
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
            }

            return back()->with('success', 'Image removed successfully.');
        }

        return back()->with('error', 'Image not found.');
    }

    /**
     * Delete a room. Prevents deletion if it has pending/approved bookings.
     * ONLY SUPER ADMIN can delete rooms.
     */
    public function destroy(Room $room): RedirectResponse
    {
        $user = Auth::user();
        
        // Only Super Admin can delete rooms
        if (!$user->isSuper()) {
            abort(403, 'Only Super Admin can delete rooms.');
        }
        
        $activeBookings = $room->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeBookings > 0) {
            return back()->with('error', 'Cannot delete "' . $room->name . '" — it has ' . $activeBookings . ' active/pending booking(s). Please reject or cancel those first.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room "' . $room->name . '" has been deleted.');
    }
}