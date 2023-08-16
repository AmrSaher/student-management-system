<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Student $student)
    {
        $student->update([
            'paid_at' => now()
        ]);

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}
