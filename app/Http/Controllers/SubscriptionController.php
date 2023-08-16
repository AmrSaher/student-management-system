<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Student $student)
    {
        $student->update([
            'paid_at' => now()
        ]);

        return back();
    }
}
