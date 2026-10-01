<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display all users.
     * ONLY SUPER ADMIN CAN ACCESS.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Only Super Admin can manage users
        if (!$user->isSuper()) {
            abort(403, 'Only Super Admin can manage users.');
        }
        
        $users = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form to create a new user.
     * ONLY SUPER ADMIN CAN ACCESS.
     */
    public function create(): View
    {
        $user = Auth::user();
        
        // Only Super Admin can create users
        if (!$user->isSuper()) {
            abort(403, 'Only Super Admin can create users.');
        }
        
        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.users.create', ['user' => null, 'rooms' => $rooms]);
    }

    /**
     * Store a newly created user.
     * ONLY SUPER ADMIN CAN ACCESS.
     */
    public function store(Request $request): RedirectResponse {
        $user = Auth::user();
        
        // Only Super Admin can create users
        if (!$user->isSuper()) {
            abort(403, 'Only Super Admin can create users.');
        }
        
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'       => ['required', 'regex:/^(?:\+?6?01)[0-46-9]-?[0-9]{7,8}$/'],
            'office_no'   => ['nullable', 'string', 'max:50'],
            'password'    => ['required', 'string', 'min:8'],
            'description' => ['nullable', 'string'],
            'is_admin'    => ['boolean'],
            'assigned_rooms' => ['nullable', 'array'],
            'assigned_rooms.*' => ['exists:rooms,id'],
        ]);

        // If user is admin, assign rooms
        $isAdmin = $request->boolean('is_admin', false);
        
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'office_no' => $validated['office_no'] ?? null,
            'password' => bcrypt($validated['password']),
            'description' => $validated['description'] ?? null,
            'is_admin' => $isAdmin,
            'is_super' => false,
            'is_active' => true,
        ];
        
        // If admin, assign rooms
        if ($isAdmin) {
            $userData['assigned_rooms'] = $validated['assigned_rooms'] ?? [];
        }
        
        User::create($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "' . $validated['name'] . '" has been created successfully.');
    }

    /**
     * Show the form to edit an existing user.
     * ONLY SUPER ADMIN CAN ACCESS.
     */
    public function edit(User $user): View {
        $currentUser = Auth::user();
        
        // Only Super Admin can edit users
        if (!$currentUser->isSuper()) {
            abort(403, 'Only Super Admin can edit users.');
        }
        
        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.users.create', compact('user', 'rooms'));
    }

    /**
     * Update an existing user.
     * ONLY SUPER ADMIN CAN ACCESS.
     */
    public function update(Request $request, User $user): RedirectResponse {
        $currentUser = Auth::user();
        
        // Only Super Admin can update users
        if (!$currentUser->isSuper()) {
            abort(403, 'Only Super Admin can update users.');
        }
        
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'       => ['required', 'regex:/^(?:\+?6?01)[0-46-9]-?[0-9]{7,8}$/'],
            'office_no'   => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'is_admin'    => ['boolean'],
            'assigned_rooms' => ['nullable', 'array'],
            'assigned_rooms.*' => ['exists:rooms,id'],
        ]);

        // Prevent removing admin status from self
        if ($user->id === $currentUser->id && $user->isSuper()) {
            $validated['is_admin'] = true;
            $validated['is_super'] = true;
        }

        // If user is admin, assign rooms
        $isAdmin = $request->boolean('is_admin', false);
        
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'office_no' => $validated['office_no'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_admin' => $isAdmin,
        ];
        
        // If admin, assign rooms
        if ($isAdmin) {
            $userData['assigned_rooms'] = $validated['assigned_rooms'] ?? [];
        } else {
            $userData['assigned_rooms'] = null;
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "' . $user->name . '" has been updated successfully.');
    }

    /**
     * Delete a user.
     * ONLY SUPER ADMIN CAN ACCESS.
     */
    public function destroy(User $user): RedirectResponse {
        $currentUser = Auth::user();
        
        // Only Super Admin can delete users
        if (!$currentUser->isSuper()) {
            abort(403, 'Only Super Admin can delete users.');
        }
        
        if ($user->is_super) {
            return back()->with('error', 'Cannot delete Super Admin user.');
        }

        $activeBookings = $user->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeBookings > 0) {
            return back()->with('error', 'Cannot delete "' . $user->name . '" — it has ' . $activeBookings . ' active/pending booking(s). Please reject or cancel those first.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User "' . $user->name . '" has been deleted.');
    }
}