<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();

        return view('students.index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        $appointments = Appointment::all();

        return view('students.create', [
            'grades' => $grades,
            'appointments' => $appointments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'digits:11', 'unique:students,phone_number'],
            'parents_phone_number' => ['required', 'string', 'digits:11', 'unique:students,parents_phone_number'],
            'slug' => ['required', 'unique:students,slug', 'string'],
            'address' => ['required', 'string'],
            'image' => ['required'],
            'grade' => ['required', 'integer'],
            'appointment' => ['required', 'integer']
        ]);

        $image_path = $request->file('image')->store('public/students_images');

        Student::create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'parents_phone_number' => $request->input('parents_phone_number'),
            'address' => $request->input('address'),
            'slug' => $request->input('slug'),
            'image_path' => $image_path,
            'grade_id' => $request->input('grade'),
            'appointment_id' => $request->input('appointment')
        ]);

        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', [
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $grades = Grade::all();
        $appointments = Appointment::all();

        return view('students.edit', [
            'student' => $student,
            'grades' => $grades,
            'appointments' => $appointments
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'digits:11'],
            'parents_phone_number' => ['required', 'string', 'digits:11'],
            'address' => $request->input('address'),
            'slug' => ['required', 'string'],
            'grade' => ['required', 'integer'],
            'appointment' => ['required', 'integer']
        ]);

        $image_path = $request->file('image') ?
                $request->file('image')->store('public/students_images') :
                $student->image_path;

        $student->update([
             ...$attrs,
            'image_path' => $image_path,
            'grade_id' => $request->input('grade'),
            'appointment_id' => $request->input('appointment')
        ]);

        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return back();
    }
}
