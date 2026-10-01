<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email',
        'phone', 'office_no', 'password',
        'is_super', 'is_admin', 'is_active',
        'description', 'assigned_rooms',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super' => 'boolean',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'assigned_rooms' => 'array',
        ];
    }

    public function isSuper(): bool {
        return $this->is_super === true;
    }

    public function isAdmin(): bool {
        return $this->is_admin === true;
    }

    public function isRegularUser(): bool {
        return !$this->is_admin && !$this->is_super;
    }

    /**
     * Check if user can manage a specific room
     */
    public function canManageRoom(int $roomId): bool
    {
        // Super Admin can manage all rooms
        if ($this->isSuper()) {
            return true;
        }

        // Regular admin can only manage assigned rooms
        if ($this->isAdmin()) {
            $assignedRooms = $this->assigned_rooms ?? [];
            return in_array($roomId, $assignedRooms);
        }

        return false;
    }

    /**
     * Get room IDs that this user can manage
     */
    public function getManageableRoomIds(): array
    {
        if ($this->isSuper()) {
            return \App\Models\Room::pluck('id')->toArray();
        }

        if ($this->isAdmin()) {
            return $this->assigned_rooms ?? [];
        }

        return [];
    }

    /**
     * Check if user has any assigned rooms
     */
    public function hasAssignedRooms(): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        if ($this->isAdmin()) {
            return !empty($this->assigned_rooms);
        }

        return false;
    }

    public function hasVerifiedEmail(): bool {
        if ($this->isAdmin() || $this->isSuper()) {
            return true;
        }
        return !is_null($this->email_verified_at);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}