<?php

namespace App\Http\Controllers;

use App\Models\Appointment; // Import the Appointment model
use App\Models\Student; // Import the Student model
use Illuminate\Http\Request;

class CounselorDashboardController extends Controller
{
    public function index()
    {
        // Fetch all appointments with student details
        $appointments = Appointment::with('student')->get();
        
        // Fetch all students with their requirements
        $students = Student::with('requirements')->get(); // Ensure your Student model has a relationship defined for requirements
        
        return view('counselor.dashboard', compact('appointments', 'students')); // Pass both variables to the view
    }
}
