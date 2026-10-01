<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Create Super Admin User ---
        $superAdmin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@moh.gov.my',
            'password' => Hash::make('password'),
            'is_super' => true,
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // --- Create Admin User (PIC Bilik) ---
        $admin = User::create([
            'name'     => 'Admin Tanjung Tuan',
            'email'    => 'admin.tanjungtuan@moh.gov.my',
            'password' => Hash::make('password'),
            'is_super' => false,
            'is_admin' => true,
            'email_verified_at' => now(),
            'assigned_rooms' => [], // Will be assigned after rooms are created
        ]);

        // --- Create Another Admin User (PIC Bilik) ---
        $admin2 = User::create([
            'name'     => 'Admin Dewan Mutiara',
            'email'    => 'admin.dewanmutiara@moh.gov.my',
            'password' => Hash::make('password'),
            'is_super' => false,
            'is_admin' => true,
            'email_verified_at' => now(),
            'assigned_rooms' => [], // Will be assigned after rooms are created
        ]);

        // --- Create Regular Users ---
        $demoEmail = config('app.demo_user_email', 'testuser@moh.gov.my');

        $user1 = User::create([
            'name'              => 'Test User',
            'email'             => $demoEmail,
            'password'          => Hash::make('password'),
            'is_super'          => false,
            'is_admin'          => false,
            'is_demo'           => true,
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name'     => 'John Doe',
            'email'    => 'johndoe@moh.gov.my',
            'password' => Hash::make('password'),
            'is_super' => false,
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // --- Create Rooms ---
        $this->call([
            RoomSeeder::class,
        ]);

        // --- Assign rooms to the admins after rooms are created ---
        $rooms = Room::where('is_active', true)->get();
        
        // Assign "Bilik Tanjung Tuan" to Admin Tanjung Tuan
        $tanjungTuan = $rooms->where('name', 'Bilik Tanjung Tuan')->first();
        if ($tanjungTuan) {
            $admin = User::where('email', 'admin.tanjungtuan@moh.gov.my')->first();
            if ($admin) {
                $admin->assigned_rooms = [$tanjungTuan->id];
                $admin->save();
            }
        }

        // Assign "Dewan Mutiara" to Admin Dewan Mutiara
        $dewanMutiara = $rooms->where('name', 'Dewan Mutiara')->first();
        if ($dewanMutiara) {
            $admin2 = User::where('email', 'admin.dewanmutiara@moh.gov.my')->first();
            if ($admin2) {
                $admin2->assigned_rooms = [$dewanMutiara->id];
                $admin2->save();
            }
        }

        // --- Create Bookings ---
        $this->call([
            BookingSeeder::class,
        ]);
    }
}