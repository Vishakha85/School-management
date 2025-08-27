<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Signup</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .signup-container { max-width: 500px; margin: 40px auto; background: #fff; padding: 32px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .signup-container h2 { text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: 500; }
        input[type="text"], input[type="file"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #1976d2; color: #fff; border: none; padding: 10px 24px; border-radius: 4px; cursor: pointer; width: 100%; }
        .success-msg { color: green; text-align: center; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Teacher Signup</h2>
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif
        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="experience">Experience</label>
                <input type="text" name="experience" id="experience" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <select name="department" id="department" required>
                    <option value="">Select Department</option>
                    @if(isset($classes))
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('department') == $class->id ? 'selected' : '' }}>{{ $class->class }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
           <input type="hidden" name="role_id" value="{{ request('role_id') }}">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
