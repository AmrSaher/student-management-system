<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $students = Student::all();
        $gradesCount = count(Grade::all());
        $appointmentsCount = count(Appointment::all());
        $monthlyReturn = 0;

        foreach ($students as $student) {
            $monthlyReturn += $student->grade->mrs;
        }

        return view('index', [
            'studentsCount' => count($students),
            'gradesCount' => $gradesCount,
            'appointmentsCount' => $appointmentsCount,
            'monthlyReturn' => $monthlyReturn
        ]);
    }
}
