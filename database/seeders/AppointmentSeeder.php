<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            'Sat/Mon/Wed',
            'Sun/Tue/Thu'
        ];

        for ($i = 1; $i <= 6; $i++) {
            for ($j = 0; $j < mt_rand(2, 5); $j++) {
                Appointment::create([
                    'days' => $days[mt_rand(0, 1)],
                    'clock' => date('H:i', rand(0, time())),
                    'grade_id' => $i
                ]);
            }
        }
    }
}
