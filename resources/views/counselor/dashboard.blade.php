<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<div class="flex">
    <aside class="w-64 bg-gray-800 h-screen p-5">
        <h3 class="text-white text-2xl mb-5">Counselor Dashboard</h3>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="text-white hover:bg-gray-700 block px-3 py-2 rounded">Appointments</a>
                </li>
                <li>
                    <a href="#" class="text-white hover:bg-gray-700 block px-3 py-2 rounded">Students</a>
                </li>
                <li>
                    <a href="#" class="text-white hover:bg-gray-700 block px-3 py-2 rounded">Reports</a>
                </li>
                <li>
                    <a href="#" class="text-white hover:bg-gray-700 block px-3 py-2 rounded">Settings</a>
                </li>
                <li>
                    <a href="#" class="text-white hover:bg-gray-700 block px-3 py-2 rounded">Logout</a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-10">
            <h3 class="text-2xl font-bold mb-5">Appointments</h3>
            <div class="overflow-x-auto mb-10">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Student</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Start Time</th>
                            <th class="py-2 px-4 border-b">End Time</th>
                            <th class="py-2 px-4 border-b">Reason</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $appointment->student->first_name }} {{ $appointment->student->last_name }}</td>
                                <td class="py-2 px-4 border-b">{{ $appointment->date }}</td>
                                <td class="py-2 px-4 border-b">{{ $appointment->start_time }}</td>
                                <td class="py-2 px-4 border-b">{{ $appointment->end_time }}</td>
                                <td class="py-2 px-4 border-b">{{ $appointment->reason }}</td>
                                <td class="py-2 px-4 border-b">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $appointment->status === 'Pending' ? 'bg-yellow-300 text-yellow-800' : ($appointment->status === 'Confirmed' ? 'bg-green-300 text-green-800' : 'bg-red-300 text-red-800') }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('appointments.confirm', $appointment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">Confirm</button>
                                    </form>
                                    <button type="button" onclick="toggleCancelForm({{ $appointment->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded ml-2">Cancel</button>
    
                                    <!-- Cancel Reason Form -->
                                    <div id="cancelForm-{{ $appointment->id }}" class="hidden mt-2">
                                        <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST">
                                            @csrf
                                            <input type="text" name="cancel_reason" placeholder="Reason for cancellation" class="border border-gray-300 p-2 rounded w-56" required>
                                            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold py-1 px-2 rounded">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        <h3 class="text-2xl font-bold mb-5">Students and Requirements</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Student</th>
                        <th class="py-2 px-4 border-b">Good Moral</th>
                        <th class="py-2 px-4 border-b">Form 137</th>
                        <th class="py-2 px-4 border-b">View Uploaded Files</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="py-2 px-4 border-b">
                                <span class="{{ $student->requirements->contains('requirement_name', 'Good Moral') && $student->requirements->firstWhere('requirement_name', 'Good Moral')->is_passed ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $student->requirements->contains('requirement_name', 'Good Moral') && $student->requirements->firstWhere('requirement_name', 'Good Moral')->is_passed ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <span class="{{ $student->requirements->contains('requirement_name', 'Form 137') && $student->requirements->firstWhere('requirement_name', 'Form 137')->is_passed ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $student->requirements->contains('requirement_name', 'Form 137') && $student->requirements->firstWhere('requirement_name', 'Form 137')->is_passed ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('uploads.show', $student->id) }}" class="text-blue-500 hover:underline">View Files</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
