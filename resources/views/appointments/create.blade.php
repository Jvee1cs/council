@extends('layouts.app')

@section('title', 'Create Appointment')

@section('content')
    <h1>Create Appointment</h1>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>
        </div>
        <div>
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required>
        </div>
        <div>
            <label for="end_time">End Time:</label>
            <input type="time" name="end_time" id="end_time" required>
        </div>
        <div>
            <label for="reason">Reason:</label>
            <input type="text" name="reason" id="reason" required>
        </div>
        <button type="submit">Book Appointment</button>
    </form>
@endsection
