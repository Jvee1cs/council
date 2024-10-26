<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{


    public function download($id)
{
    $requirement = Requirement::findOrFail($id);

    // Ensure that the authenticated user is the owner of the requirement
    if ($requirement->student_id !== auth()->id()) {
        abort(403, 'Unauthorized access.');
    }

    // Return the file for download
    return Storage::download($requirement->file_path, $requirement->file_name);
}

    public function index()
    {
        // Fetch requirements for the authenticated student
        $requirements = Requirement::where('student_id', auth()->id())->get();
        return view('student.requirements', compact('requirements'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'requirement_name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,docx,jpg,png|max:2048',
        ]);

        // Create a unique file name using the student ID and requirement name
        $studentId = auth()->id();
        $requirementName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->requirement_name); // Sanitize the requirement name
        $uniqueFileName = $studentId . '_' . $requirementName . '_' . time() . '.' . $request->file('file')->extension();

        // Store the file with the unique name
        $filePath = $request->file('file')->storeAs('requirements', $uniqueFileName);

        // Create a requirement entry in the database
        Requirement::create([
            'student_id' => $studentId,
            'requirement_name' => $request->requirement_name,
            'file_name' => $uniqueFileName, // Save the unique file name in the database
            'file_path' => $filePath,
            'is_passed' => true,
            'deadline' => $request->deadline,
        ]);

        return response()->json(['message' => 'Requirement uploaded successfully']);
    }

    public function delete($id)
    {
        $requirement = Requirement::where('id', $id)->where('student_id', auth()->id())->first();

        if ($requirement) {
            // Delete the file from storage
            Storage::delete($requirement->file_path);
            $requirement->delete();
            return response()->json(['message' => 'Requirement deleted successfully']);
        }

        return response()->json(['error' => 'Requirement not found'], 404);
    }

    
}
