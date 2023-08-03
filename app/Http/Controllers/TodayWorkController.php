<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class TodayWorkController extends Controller
{
    public function index()
    {
        // Days Groups
        $dg1 = ['Saturday', 'Monday', 'Wednesday'];
        $dg2 = ['Sunday', 'Tuesday', 'Thursday'];

        $today = date('l');
        $query = in_array($today, $dg1) ? 'Sat/Mon/Wed' : (
            in_array($today, $dg2) ? 'Sun/Tue/Thu' : null
        );

        $appointments = is_null($query) ? [] : Appointment::where('days', $query)->get();
        $grades = [];

        foreach ($appointments as $appointment) {
            $grades[] = $appointment->grade;
        }
        array_unique($grades);

        return view('appointments.work.index', [
            'grades' => $grades,
            'appointments' => $appointments
        ]);
    }

    public function start(Appointment $appointment)
    {
        $students = $appointment->students;

        foreach ($students as $student) {
            $student->update([
                'isExist' => $student->isExist ? false : true
            ]);
        }

        return view('appointments.work.start', [
            'appointment' => $appointment
        ]);
    }

    public function scan(Student $student, Appointment $appointment)
    {
        $studentExist = !is_null($appointment->students()->find($student->id));

        if (!$studentExist) return response()->json([
            'message' => 'Student is not exist in this group'
        ], 404);

        if ($student->isExist) {
            $student->update([
                'isExist' => false
            ]);

            return response()->json([
                'message' => 'Student is absent'
            ], 404);
        }

        $student->update([
            'isExist' => true
        ]);

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}
