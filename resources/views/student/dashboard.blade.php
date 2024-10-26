<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hide all sections by default */
        .section {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Student Dashboard</h1>
            <div class="flex items-center space-x-6">
                <button class="text-gray-600 hover:text-blue-500" onclick="showSection('dashboard')">Dashboard</button>
                <button class="text-gray-600 hover:text-blue-500" onclick="showSection('violations')">Violations</button>
                <button class="text-gray-600 hover:text-blue-500" onclick="showSection('appointments')">Appointments</button>
                <button class="text-gray-600 hover:text-blue-500" onclick="showSection('requirements')">Requirements</button>
                <button class="text-gray-600 hover:text-blue-500" onclick="showSection('profile')">Profile</button>
                <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 py-2 px-4 hover:text-blue-500">Logout</button>
                </form>
                        </div>
        </div>
    </nav>
<!-- Toast Notification -->
<div id="toast" class="fixed bottom-5 right-5 hidden bg-green-500 text-white p-4 rounded-lg shadow-lg">
    <span id="toastMessage"></span>
</div>
    <div class="container mx-auto mt-10 grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="bg-white p-6 rounded-lg shadow-md col-span-1">
            <div class="flex items-center space-x-4 mb-6">
                <img src="https://via.placeholder.com/50" class="w-12 h-12 rounded-full" alt="Profile Picture">
                <div>
                    <h3 class="text-lg font-semibold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h3>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav>
                <ul class="space-y-4">
                    <li>
                        <button class="flex items-center space-x-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 p-2 rounded-md" onclick="showSection('dashboard')">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M3 12l18-9v18L3 12z"/>
                            </svg>
                            <span>Dashboard</span>
                        </button>
                    </li>
                    <li>
                        <button class="flex items-center space-x-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 p-2 rounded-md" onclick="showSection('violations')">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M5 3v18l7-5 7 5V3L12 8 5 3z"/>
                            </svg>
                            <span>Violations</span>
                        </button>
                    </li>
                    <li>
                        <button class="flex items-center space-x-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 p-2 rounded-md" onclick="showSection('appointments')">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 22L2 12l10-10 10 10-10 10z"/>
                            </svg>
                            <span>Appointments</span>
                        </button>
                    </li>
                    <li>
                        <button class="flex items-center space-x-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 p-2 rounded-md" onclick="showSection('requirements')">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 22L2 12l10-10 10 10-10 10z"/>
                            </svg>
                            <span>Requirements</span>
                        </button>
                    </li>
                    <li>
                        <button class="flex items-center space-x-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 p-2 rounded-md" onclick="showSection('profile')">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 12m0-6a6 6 0 1 0 0 12 6 6 0 0 0 0-12z"/>
                            </svg>
                            <span>Profile</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-span-3 bg-white p-6 rounded-lg shadow-md space-y-8">

            <!-- Dashboard Section -->
            <div id="dashboard" class="section">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Welcome to Your Dashboard</h4>
                <p class="text-gray-600">This is your personalized dashboard.</p>
            </div>

            <!-- Violations Section -->
            <div id="violations" class="section">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Your Violations</h4>
                @if($violations->isEmpty())
                    <p class="text-gray-600">No violations found.</p>
                @else
                    <ul class="list-disc list-inside">
                        @foreach($violations as $violation)
                            <li class="text-gray-700">{{ $violation->description }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
<!-- Requirements Section -->
<div id="requirements" class="section">
    <h4 class="text-xl font-semibold text-gray-700 mb-4">Your Requirements</h4>

    <!-- Upload New Requirement Form -->
    <form id="uploadRequirementForm" onsubmit="uploadRequirement(event)" enctype="multipart/form-data">
        <div>
            <label for="requirement_name" class="block text-gray-700">Requirement Name:</label>
            <select name="requirement_name" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="Good Moral">Good Moral</option>
                <option value="Form 137">Form 137</option>
                <!-- Add other requirement options as needed -->
            </select>
        </div>
        <div class="mt-2">
            <label for="file" class="block text-gray-700">Upload File:</label>
            <input type="file" name="file" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mt-2">
            <label for="deadline" class="block text-gray-700">Deadline:</label>
            <input type="date" name="deadline" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Upload Requirement</button>
    </form>

    <!-- Display Uploaded Requirements -->
    <h4 class="text-lg font-semibold text-gray-700 mt-6">Uploaded Requirements</h4>
    <ul id="requirementsList" class="list-disc list-inside space-y-2">
        @if($requirements->isEmpty())
            <p class="text-gray-600">No requirements uploaded.</p>
        @else
            @foreach($requirements as $requirement)
                <li class="flex justify-between items-center">
                    <span>{{ $requirement->requirement_name }} - {{ $requirement->deadline }} ({{ $requirement->is_passed ? 'Passed' : 'Pending' }})</span>
                    <button onclick="deleteRequirement({{ $requirement->id }})" class="bg-red-600 text-white py-1 px-2 rounded-md hover:bg-red-700">Delete</button>
                </li>
            @endforeach
        @endif
    </ul>
</div>
          <!-- Appointments Section -->
<div id="appointments" class="section">
    <h4 class="text-xl font-semibold text-gray-700 mb-4">Your Appointments</h4>
    <button onclick="openAppointmentModal()" class="bg-blue-500 text-white py-2 px-4 rounded-md">Book New Appointment</button>
    @if($appointments->isEmpty())
        <p class="text-gray-600">No appointments found.</p>
    @else
        <ul class="list-disc list-inside">
            @foreach($appointments as $appointment)
                <li class="text-gray-700 cursor-pointer" onclick="showAppointmentDetails({{ $appointment->id }})">
                    {{ $appointment->date }}: {{ $appointment->start_time }} - {{ $appointment->end_time }} (Status: {{ $appointment->status }})
                </li>
            @endforeach
        </ul>
    @endif
</div>

<!-- Modal for Booking Appointment -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Book a New Appointment</h4>
        <form id="appointmentForm" onsubmit="submitAppointment(event)">
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
                <input type="text" name="reason" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="mt-4 w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Book Appointment</button>
            <button type="button" onclick="closeBookingModal()" class="mt-2 w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700">Close</button>
        </form>
    </div>
</div>

        
            <!-- Profile Section -->
            <div id="profile" class="section">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Update Profile</h4>
                <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="first_name" class="block text-gray-700">First Name:</label>
                        <input type="text" name="first_name" value="{{ auth()->user()->first_name }}" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-gray-700">Last Name:</label>
                        <input type="text" name="last_name" value="{{ auth()->user()->last_name }}" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700">Email:</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>
                    <div>
                        <label for="student_number" class="block text-gray-700">Student Number:</label>
                        <input type="text" name="student_number" value="{{ auth()->user()->student_number }}" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Update Profile</button>
                </form>
            </div>

        </div>
       <!-- Appointment Details Modal -->
<div id="appointmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
        <h4 class="text-xl font-semibold text-gray-700 mb-4" id="modalTitle"></h4>
        <p id="modalDate"></p>
        <p id="modalTime"></p>
        <p id="modalReason"></p>
        <button onclick="closeModal()" class="mt-4 w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700">Close</button>
    </div>
</div>

<!-- Modal for Booking Appointment -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Book a New Appointment</h4>
        <form id="appointmentForm" onsubmit="submitAppointment(event)">
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
                <input type="text" name="reason" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="mt-4 w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Book Appointment</button>
            <button type="button" onclick="closeBookingModal()" class="mt-2 w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700">Close</button>
        </form>
    </div>
</div>
    </div>

    <script>
         function uploadRequirement(event) {
        event.preventDefault();
        const formData = new FormData(document.getElementById('uploadRequirementForm'));
        
        fetch('/requirements/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Error uploading requirement');
            return response.json();
        })
        .then(data => {
            alert(data.message);
            location.reload(); // Refresh the page to show the uploaded requirement
        })
        .catch(error => alert('Error: ' + error.message));
    }

    function deleteRequirement(id) {
        if (!confirm('Are you sure you want to delete this requirement?')) return;
        
        fetch(`/requirements/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Error deleting requirement');
            return response.json();
        })
        .then(data => {
            alert(data.message);
            location.reload(); // Refresh the page to reflect the deletion
        })
        .catch(error => alert('Error: ' + error.message));
    }
    
        function openAppointmentModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
}

function submitAppointment(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('appointmentForm'));
    fetch('/student/appointments', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json' // Expect JSON response
    }
})
.then(response => {
    if (!response.ok) {
        return response.text().then(text => {
            throw new Error(`Server Error: ${response.status} - ${text}`); // Log the error text
        });
    }
    return response.json(); // Parse JSON response
})
.then(data => {
    closeBookingModal();
    alert(data.message); // Show success message
})
.catch(error => {
    alert('Error: ' + error.message); // Handle error messages
});

}


       function showAppointmentDetails(id) {
    // Fetch appointment details using AJAX
    fetch(`/appointments/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Appointment not found');
            return response.json();
        })
        .then(data => {
            // Populate modal with appointment details
            document.getElementById('modalTitle').innerText = 'Appointment Details';
            document.getElementById('modalDate').innerText = `Date: ${data.date}`;
            document.getElementById('modalTime').innerText = `Time: ${data.start_time} - ${data.end_time}`;
            document.getElementById('modalReason').innerText = `Reason: ${data.reason}`;
            
            // Show the modal
            document.getElementById('appointmentModal').classList.remove('hidden');
        })
        .catch(error => {
            alert(error.message);
        });
}

function closeModal() {
    document.getElementById('appointmentModal').classList.add('hidden');
}

        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => section.style.display = 'none');

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        // Show the dashboard section by default
        showSection('dashboard');

        
    </script>

</body>
</html>
