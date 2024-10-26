<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // Other methods...

    public function update(Request $request)
    {
        // Fetch the currently authenticated student
        $student = auth()->user();

        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'student_number' => 'required|string|max:255|unique:students,student_number,' . $student->id,
            'password' => 'nullable|confirmed|min:8', // Optional password update
        ]);

        // Update the student's profile details
        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'student_number' => $request->student_number,
            // If a password is provided, update it
            'password' => $request->password ? Hash::make($request->password) : $student->password,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
