<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add College Information</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    @role('admin')
        @if(session('success'))
            <div style="color: green; font-weight: bold;">{{ session('success') }}</div>
            <script>
                setTimeout(function() {
                    window.location.href = "{{ url('/dashboard') }}";
                }, 3000);
            </script>
        @else
            <form action="{{ url('/admin/addstudent-college') }}" method="POST">
                <h2>Add College Information for Student</h2>
                @csrf
                <label>Student ID:</label>
                <input type="number" name="std_id" value="{{ $student_id ?? '' }}" readonly class="input-field"><br>
                <label>Student Name:</label>
                <input type="text" value="{{ $student_name ?? '' }}" readonly><br>
                <label>College Name:</label>
                <input type="text" name="name" required><br>
                <label>Branch:</label>
                <input type="text" name="branch" required><br>
                <label>Passout Year:</label>
                <input type="number" name="passoutyear" min="1900" max="2099" required class="input-field"><br>
                <button type="submit">Add Student</button>
            </form>
        @endif
    @else
        <div style="color: red; font-weight: bold;">
            Access denied. Please <a href="{{ url('/login') }}">login as admin</a> to access this page.
        </div>
    @endrole
</body>
</html>
