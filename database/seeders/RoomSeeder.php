<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Ruang Rapat 1',
            'capacity' => 20,
            'facilities' => 'AC, Proyektor, Papan Tulis',
        ]);

        Room::create([
            'name' => 'Ruang Diskusi 1',
            'capacity' => 10,
            'facilities' => 'AC, Papan Tulis',
        ]);

        Room::create([
            'name' => 'Auditorium',
            'capacity' => 200,
            'facilities' => 'AC, Proyektor, Sound System',
        ]);
    }
}
