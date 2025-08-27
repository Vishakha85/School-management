<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Profile</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
@role('student')
    @if($student)
        <form method="POST" action="/students/{{ $student->id }}">
            @csrf
            @method('PUT')
            <h2>Edit Your Profile</h2>
            <label>ID:</label>
            <input type="text" name="id" value="{{ $student->id }}" readonly><br>
            <label>Name:</label>
            <input type="text" name="name" value="{{ $student->name }}" required><br>
            <label>Email:</label>
            <input type="text" name="email" value="{{ $student->email }}" required ><br>
            <label>Class:</label>
            <input type="text" value="{{ $className ?? '' }}" disabled><br>
            <label>Number:</label>
            <input type="text" name="number" value="{{ $student->number }}" required><br>
            <label>Age:</label>
            <input type="text" name="age" value="{{ $student->age }}" required><br>
            <label>Password:</label>
            <input type="text" name="password" value="{{ $student->password }}" required disabled><br>
            <button type="submit">Save</button>
            <a href="{{ url('/students/studentdash') }}" class="btn btn-secondary">Back</a>
        </form>
    @else
        <p>No student data found.</p>
    @endif
@else
    <div style="color: red; font-weight: bold;">Access denied. Please <a href="{{ url('/login') }}">login as student</a> to access this page.</div>
@endrole
</body>
</html>
