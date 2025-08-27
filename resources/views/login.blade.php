<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
     <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    
    <form action="/login" method="POST">
        @if(session('success'))
            <div style="color: green; margin-bottom: 10px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="color: red; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif
        @csrf
         <h2>Login</h2>
          @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" >
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        <div style="text-align: right; margin-top: 4px;">
            <a href="{{ route('password.request') }}" style="color: #1976d2; text-decoration: underline; font-size: 0.95rem;">Forgot Password?</a>
        </div>
        </div>

         <!-- <div>
        <label for="role">Login as</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="student">Student</option>
        </select>
    </div> -->

        <button type="submit">Login</button>
        <div >
        <p>Don't have an account? <a href="{{ route('choose_user') }}">Signup here</a></p>
        </div>
    </form>

</body>
</html>
