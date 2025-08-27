<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
        input[type="password"] {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            margin-bottom: 1.2rem;
            font-size: 1rem;
            background: #f9fafb;
            transition: border 0.2s;
        }
        input[type="password"]:focus {
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
        .error {
            margin-bottom: 1rem;
            padding: 0.7rem 1rem;
            border-radius: 5px;
            font-size: 0.97rem;
            background: #fee2e2;
            color: #b91c1c;
        }
        .success {
            margin-bottom: 1rem;
            padding: 0.7rem 1rem;
            border-radius: 5px;
            font-size: 0.97rem;
            background: #d1fae5;
            color: #065f46;
        }
    </style>
</head>
<body>
    <form action="{{ route('password.update.custom') }}" method="POST" onsubmit="return validatePasswords();">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <h2>Reset Password</h2>
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <label>New Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Save</button>
    </form>
    <script>
        function validatePasswords() {
            const pwd = document.querySelector('[name="password"]').value;
            const cpwd = document.querySelector('[name="password_confirmation"]').value;
            if (pwd !== cpwd) {
                alert('Passwords do not match.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
