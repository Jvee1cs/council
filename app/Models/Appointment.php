<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', // Foreign key linking to the Student
        'counselor_id',
        'date',
        'start_time',
        'end_time',
        'reason',
        'status', // e.g., 'Pending', 'Confirmed', 'Cancelled', etc.
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
