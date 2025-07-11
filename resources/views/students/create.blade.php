<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <form action="{{ url('students') }}" method="POST">
        <h2>Signup Form For Students</h2>
    
        @if(session('success'))
            <div style="color: green;">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="class">Class:</label>
            <input type="text" id="class" name="class" value="{{ old('class') }}">
            @error('class')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="number">Number:</label>
            <input type="text" id="number" name="number" value="{{ old('number') }}">
            @error('number')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" value="{{ old('age') }}">
            @error('age')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>
         <div>
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="password" value="{{ old('password') }}">
            @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>
        <button type="submit">Submit</button>
        <div>
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </form>

</body>
</html>
