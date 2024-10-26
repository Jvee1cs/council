<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('counselor_id')->nullable()->constrained()->onDelete('set null'); // Allow null for counselors
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('reason');
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
