<?php

namespace App\Http\Controllers;

use App\Models\Student; // Import the Student model
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function show(Student $student)
    {
        return view('uploads', compact('student'));
    }
}
