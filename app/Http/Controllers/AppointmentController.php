<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string|max:255',
            'counselor_id' => 'nullable|exists:counselors,id', // Validate counselor_id if needed
        ]);
    
        // Create the appointment
        $appointment = Appointment::create([
            'student_id' => Auth::id(), // Ensure student_id is set correctly
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
            'counselor_id' => $request->counselor_id,
            'status' => 'Pending', // Default status
        ]);
    
        // Return a JSON response
        return response()->json(['message' => 'Appointment booked successfully!', 'appointment' => $appointment]);
    }
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'Confirmed';
        $appointment->save();

        return redirect()->route('counselor.dashboard')->with('success', 'Appointment confirmed.');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'Cancelled';
        $appointment->save();

        return redirect()->route('counselor.dashboard')->with('success', 'Appointment cancelled.');
    }

    public function show($id)
    {
        $appointment = Appointment::find($id);

        // Debugging statement
        \Log::info('Fetching appointment with ID: ' . $id);

        if (!$appointment) {
            \Log::error('Appointment not found with ID: ' . $id);
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        return response()->json($appointment);
    }
}
