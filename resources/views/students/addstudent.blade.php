
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD STUDENT</title>
       <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<form action="{{ url('/students/addstudent') }}" method="POST">
    <h2>Add New Student</h2>
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required><br>

    <label>Class:</label>
    <input type="text" name="class" required><br>

    <label>Number:</label>
    <input type="text" name="number" required><br>

    <label>Age:</label>
    <input type="text" name="age" required><br>

    <label>Password:</label>
    <input type="password" name="password" required><br>

    <!-- <label>Status:</label>
    <select name="status" required>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select><br><br> -->

    <button type="submit">Add Student</button>
</form>  
</body>
</html>