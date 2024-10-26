<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Book a New Appointment</h4>
        <form action="{{ route('student.appointments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="date" class="block text-gray-700">Date:</label>
                <input type="date" name="date" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="start_time" class="block text-gray-700">Start Time:</label>
                <input type="time" name="start_time" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="end_time" class="block text-gray-700">End Time:</label>
                <input type="time" name="end_time" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="reason" class="block text-gray-700">Reason:</label>
                <textarea name="reason" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Book Appointment</button>
        </form>
        <a href="{{ route('student.dashboard') }}" class="mt-4 inline-block text-blue-600 hover:underline">Back to Dashboard</a>
    </div>
</body>
</html>
