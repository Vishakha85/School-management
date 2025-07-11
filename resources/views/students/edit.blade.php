<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Profile</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
@if($student)
<form method="POST" action="/students/{{ $student->id }}">
    @csrf
    @method('PUT')
    <h2>Edit Your Profile</h2>
    <label>ID:</label>
    <input type="text" name="id" value="{{ $student->id }}" readonly><br>

    <label>Name:</label>
    <input type="text" name="name" value="{{ $student->name }}" required><br>

    <label>Class:</label>
    <input type="text" name="class" value="{{ $student->class }}" required><br>

    <label>Number:</label>
    <input type="text" name="number" value="{{ $student->number }}" required><br>

    <label>Age:</label>
    <input type="text" name="age" value="{{ $student->age }}" required><br>

    <label>Password:</label>
    <input type="text" name="password" value="{{ $student->password }}" required><br>

    <button type="submit">Save</button>
    <span style="display:inline-block; width: 20px;"></span>
    <a href="/students/studentdash">Cancel</a>
</form>
@else
    <p>No student data found.</p>
@endif
</body>
</html>
