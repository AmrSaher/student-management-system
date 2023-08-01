<?php

namespace App\Http\Controllers;

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
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'unique:students,slug', 'string'],
            'image' => ['required']
        ]);

        $image_path = $request->file('image')->store('public/students_images');

        Student::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'image_path' => $image_path
        ]);

        return redirect()->route('students.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string']
        ]);

        $image_path = $request->file('image') ?
                $request->file('image')->store('public/students_images') :
                $student->image_path;

        $student->update([
             ...$attrs,
            'image_path' => $image_path
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
