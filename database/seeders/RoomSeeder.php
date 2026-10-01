<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name'        => 'Dewan Mutiara',
                'capacity'    => 60,
                'pic'         => 'Unit Pentadbiran',
                'pic_email'   => 'adminhpd@moh.gov.my',
                'building'    => 'Kompleks Pengurusan',
                'description' => 'Suitable for event or program.',
                'facilities'  => [],
                'images'      => [
                    'https://picsum.photos/seed/GKB1B201_1/800/600',
                    'https://picsum.photos/seed/GKB1B201_2/800/600',
                    'https://picsum.photos/seed/GKB1B201_3/800/600',
                ],
                'is_active'   => true,
            ],
            [
                'name'        => 'Bilik Tanjung Tuan',
                'capacity'    => 40,
                'pic'         => 'Unit Pentadbiran',
                'pic_email'   => 'adminhpd@moh.gov.my',
                'building'    => 'Kompleks Pengurusan',
                'description' => 'Discussion room suitable for meetings.',
                'facilities'  => [],
                'images'      => [
                    'https://picsum.photos/seed/GKB2Seminar_1/800/600',
                    'https://picsum.photos/seed/GKB2Seminar_2/800/600',
                ],
                'is_active'   => true,
            ],
            [
                'name'        => 'Bilik Gerakan',
                'capacity'    => 20,
                'pic'         => 'Unit Pentadbiran',
                'pic_email'   => 'adminhpd@moh.gov.my',
                'building'    => 'Kompleks Pengurusan',
                'description' => 'Discussion room suitable for small meetings.',
                'facilities'  => [],
                'images'      => [
                    'https://picsum.photos/seed/GKB2Seminar_1/800/600',
                    'https://picsum.photos/seed/GKB2Seminar_2/800/600',
                ],
                'is_active'   => true,
            ],
            [
                'name'        => 'Bilik Latihan ICT - Teluk Kemang',
                'capacity'    => 10,
                'pic'         => 'Unit Teknologi Maklumat',
                'pic_email'   => 'icthpd@moh.gov.my',
                'building'    => 'Kompleks Pengurusan',
                'description' => 'Computer lab with ± 10 PC, suitable for training with hands-on material.',
                'facilities'  => [],
                'images'      => [
                    'https://picsum.photos/seed/GKB3Lab_1/800/600',
                    'https://picsum.photos/seed/GKB3Lab_2/800/600',
                    'https://picsum.photos/seed/GKB3Lab_3/800/600',
                ],
                'is_active'   => true,
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }
    }
}