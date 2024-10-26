<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'requirements';

    // Mass assignable attributes
    protected $fillable = [
        'student_id',
        'requirement_name',
        'file_name',  // Add file_name for the uploaded file's unique name
        'file_path',  // Add file_path to store the storage path of the file
        'is_passed',
        'deadline',
    ];

    /**
     * Get the student that owns the requirement.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
