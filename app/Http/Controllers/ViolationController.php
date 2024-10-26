<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{public function addViolation(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string|max:255',
        ]);
    
        Violation::create([
            'student_id' => $request->student_id,
            'description' => $request->description,
        ]);
    
        return redirect()->back()->with('success', 'Violation added successfully.');
    }
    
}
