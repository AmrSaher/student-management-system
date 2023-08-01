<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function __invoke()
    {
        return view('scanner');
    }
}
