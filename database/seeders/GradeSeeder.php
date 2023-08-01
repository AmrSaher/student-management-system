<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            'اولى اعدادى',
            'تانية اعدادى',
            'تالتة اعدادى',
            'اولى ثانوى',
            'تانية ثانوى',
            'تالتة ثانوى',
        ];

        foreach ($grades as $grade) {
            Grade::create([
                'name' => $grade
            ]);
        }
    }
}
