<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Password Reset</title>
    <style>
        body {
            background: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            min-width: 320px;
        }
        h2 {
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #444;
            font-weight: 500;
        }
        input[type="email"] {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            margin-bottom: 1.2rem;
            font-size: 1rem;
            background: #f9fafb;
            transition: border 0.2s;
        }
        input[type="email"]:focus {
            border: 1.5px solid #6366f1;
            outline: none;
        }
        button[type="submit"] {
            width: 100%;
            padding: 0.7rem;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #4f46e5;
        }
        .status {
            margin-bottom: 1rem;
            padding: 0.7rem 1rem;
            border-radius: 5px;
            font-size: 0.97rem;
            background: #d1fae5;
            color: #065f46;
        }
        .error {
            margin-bottom: 1rem;
            padding: 0.7rem 1rem;
            border-radius: 5px;
            font-size: 0.97rem;
            background: #fee2e2;
            color: #b91c1c;
        }
        a {
            display: inline-block;
            margin-top: 1.2rem;
            color: #6366f1;
            text-decoration: none;
            font-size: 0.97rem;
            text-align: center;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form action="{{ route('password.request.verify') }}" method="POST">
        @csrf
        <h2>Request Password Reset</h2>
        @if(session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Verification Email</button>
          <div >
            <a href="{{ route('login') }}" >Back to Login</a>
        </div>
    </form>
</body>
</html>
