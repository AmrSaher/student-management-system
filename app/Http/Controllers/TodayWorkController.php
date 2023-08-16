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
        $grades = array_unique($grades);

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
                'isExist' => !$student->isExist
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
            'message' => 'Student is not exist in this group',
            'messageColor' => 'danger'
        ], 404);

        if ($student->isExist) {
            $student->update([
                'isExist' => false
            ]);

            return response()->json([
                'message' => 'Student is absent',
                'messageColor' => 'danger'
            ], 404);
        }

        $student->update([
            'isExist' => true
        ]);

        return response()->json([
            'message' => $student->isPaid() ? 'Success' : 'Success<p class="text-danger">but the monthly subscription fee was not paid</p>',
            'messageColor' => 'success',
            'isPaid' => $student->isPaid(),
            'studentID' => $student->id
        ], 200);
    }
}
