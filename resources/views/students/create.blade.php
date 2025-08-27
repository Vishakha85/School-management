<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <form action="{{ url('students') }}" method="POST" enctype="multipart/form-data">
        <h2>Signup Form For Students</h2>
    
        @if(session('success'))
            <div style="color: green;">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="class">Class:</label>
            <select id="class" name="class" required>
                <option value="">Select Class</option>
                @if(isset($classes))
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class') == $class->id ? 'selected' : '' }}>{{ $class->class }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="number">Number:</label>
            <input type="text" id="number" name="number" value="{{ old('number') }}" required>
        </div>

        <div>
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" value="{{ old('age') }}" required>
        </div>

        <br>

        <div>
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>

        <div>
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="password" value="{{ old('password') }}" required>
        </div>
        
       <input type="hidden" name="role_id" value="{{ request('role_id') }}">

        <br>
        <button type="submit">Submit</button>
        <div>
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </form>

</body>
</html>
