<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Verification</title>
</head>
<body>
    <p>Hello,</p>
    <p>You requested a password reset. Please click the link below to reset your password:</p>
    <p>
       <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">
            Reset Password
        </a>
    </p>
    <p>If you did not request this, please ignore this email.</p>
</body>
</html>
