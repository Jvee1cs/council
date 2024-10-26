<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Violation;
use App\Models\Requirement;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Get the logged-in student
        $student = Auth::guard('student')->user();

        // Fetch violations, requirements, and appointments for the student
        $violations = Violation::where('student_id', $student->id)->get();
        $requirements = Requirement::where('student_id', $student->id)->get();
        $appointments = Appointment::where('student_id', $student->id)->get();

        return view('student.dashboard', compact('student', 'violations', 'requirements', 'appointments'));
    }
    public function updateProfile(Request $request)
    {
        // Validate the input data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . auth()->id(),
            'student_number' => 'required|string|max:255|unique:students,student_number,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed', // Password is optional
        ]);

        // Get the authenticated student
        $student = Auth::guard('student')->user();

        // Update the student's profile
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->student_number = $request->student_number;

        // Check if password is provided, if yes, hash and update
        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        // Save the updated student
        $student->save();

        // Redirect back with success message
        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully.');
    }
}
