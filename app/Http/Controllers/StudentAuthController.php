<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    // Show Registration Form
    public function showRegistrationForm()
    {
        return view('auth.student_register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'student_number' => 'required|string|max:255|unique:students',
            'password' => 'required|string|min:8|confirmed',
            
        ]);

        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'student_number' => $request->student_number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($student);

        return redirect()->route('login'); // Assuming dashboard route exists
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.student_login');
    }

    // Handle Login
    public function login(Request $request)
{
    // Validate login request
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Attempt to log in
    if (Auth::guard('student')->attempt($credentials)) {
        // Authentication passed
        return redirect()->route('student.dashboard');
    }

    // If login fails, redirect back with an error message
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


    // Handle Logout
    public function logout(Request $request)
    {
        // Log the user out of the application
        Auth::logout();
    
        // Invalidate the session
        $request->session()->invalidate();
    
        // Regenerate the session token to avoid session fixation
        $request->session()->regenerateToken();
    
        // Redirect the user to the login page
        return redirect()->route('student.login');
    }
}
