<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Password Reset</title>
   
</head>
<body>
    <form action="{{ route('password.request.verify') }}" method="POST">
        @csrf
        <h2 >Request Password Reset</h2>
        @if(session('error'))
            <div>{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div >{{ session('success') }}</div>
        @endif
        <div >
            <label for="email">Enter your Email</label>
            <input type="email" id="email" name="email" required >
        </div>
        <button type="submit" >Send Verification Email</button>
        <div >
            <a href="{{ route('login') }}" >Back to Login</a>
        </div>
    </form>
</body>
</html>
