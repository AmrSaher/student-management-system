<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function show(Student $student)
    {
        return response()->json([
            'student' => $student,
            'grade' => $student->grade->name,
            'appointment' => $student->appointment->days . ' - ' . $student->appointment->clock . ' - <strong>' . $student->grade->mrs . ' L.E</strong>'
        ], 200);
    }
}
