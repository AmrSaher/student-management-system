<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Grade;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::latest()->get();

        return view('appointments.index', [
            'appointments' => $appointments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();

        return view('appointments.create', [
            'grades' => $grades
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        Appointment::create([
            'days' => $request->input('days'),
            'clock' => $request->input('clock'),
            'grade_id' => $request->input('grade')
        ]);

        return redirect()->route('appointments.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $grades = Grade::all();

        return view('appointments.edit', [
            'appointment' => $appointment,
            'grades' => $grades
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update([
            'days' => $request->input('days'),
            'clock' => $request->input('clock'),
            'grade_id' => $request->input('grade')
        ]);

        return redirect()->route('appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return back();
    }
}
