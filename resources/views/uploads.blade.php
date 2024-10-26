<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files for {{ $student->first_name }} {{ $student->last_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans p-10">
    <h1 class="text-2xl font-bold mb-5">Uploaded Files for {{ $student->first_name }} {{ $student->last_name }}</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">File Name</th>
                    <th class="py-2 px-4 border-b">Uploaded At</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->requirements as $requirement)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $requirement->requirement_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $requirement->created_at }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('requirements.download', $requirement->id) }}" class="text-blue-500 hover:underline">Download</a>                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
