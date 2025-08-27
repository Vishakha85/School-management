<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Students</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <h2>Assigned Students for {{ $teacher->name }}</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <!-- <th>Class</th> -->
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <!-- <td>{{ $student->class }}</td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="4">No students assigned.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        <a href="{{ url('/teacher/panel/' . $teacher->id) }}" class="btn-back">Back to Panel</a>
    </div>
</body>
</html>
