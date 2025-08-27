
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD STUDENT</title>
       <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <script>
            window.onload = function() {
                alert('Student added successfully!');
            }
        </script>
    @endif
<form action="{{ url('/students/addstudent') }}" method="POST">
    <h2>Add New Student</h2>
    @csrf

    <label>Name:</label>
    <input type="text" name="name" value="{{ old('name', request('name')) }}" required><br>

    <label>Email:</label>
    <input type="text" name="email" value="{{ old('email', request('email')) }}" required><br>

    <label>Class:</label>
    <select name="class" required>
        <option value="">Select Class</option>
        @foreach(config('student_classes') as $id => $className)
            <option value="{{ $id }}" {{ old('class', request('class')) == $id ? 'selected' : '' }}>{{ $className }}</option>
        @endforeach
    </select><br>

    <label>Number:</label>
    <input type="text" name="number" value="{{ old('number', request('number')) }}" required><br>

    <label>Age:</label>
    <input type="text" name="age" value="{{ old('age', request('age')) }}" required><br>

    <label>Password:</label>
    <input type="password" name="password" value="{{ old('password', request('password')) }}" required><br>

    <!-- <label>Status:</label>
    <select name="status" required>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select><br><br> -->

    <button type="submit">Save</button>
    <a href="{{ url('/dashboard') }}" class="btn-add" style="display:inline-block;margin-top:10px;">Back to Dashboard</a>
</form>  
</body>
</html>