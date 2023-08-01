<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::latest()->get();

        return view('grades.index', [
            'grades' => $grades
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string', 'unique:grades,name']
        ]);

        Grade::create($attrs);

        return redirect()->route('grades.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return view('grades.edit', [
            'grade' => $grade
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string']
        ]);

        $grade->update($attrs);

        return redirect()->route('grades.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return back();
    }
}
