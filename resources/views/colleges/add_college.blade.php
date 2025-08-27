<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add College Info</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <h2>Add College Information for {{ $student_name }}</h2>
    <form action="{{ url('/colleges/store') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student_id }}">
        <label>College Name:</label>
        <input type="text" name="college_name" required><br>
        <label>College Address:</label>
        <input type="text" name="college_address" required><br>
        <!-- Add more college fields as needed -->
        <button type="submit">Add Student</button>
    </form>
</body>
</html>
