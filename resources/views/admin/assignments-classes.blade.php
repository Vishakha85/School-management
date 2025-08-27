<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assignments - Select Class</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/assignments-classes.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <div class="assignment-box">
            <h2>Select Class to Add Assignment</h2>
            <div class="class-buttons">
                <a href="{{ url('/admin/assignments/btech') }}" class="class-btn">B.Tech</a>
                <a href="{{ url('/admin/assignments/mtech') }}" class="class-btn">M.Tech</a>
                <a href="{{ url('/admin/assignments/mca') }}" class="class-btn">MCA</a>
                <a href="{{ url('/admin/assignments/bca') }}" class="class-btn">BCA</a>
                <a href="{{ url('/admin/assignments/bcom') }}" class="class-btn">BCOM</a>
                <a href="{{ url('/admin/assignments/phd') }}" class="class-btn">PHD</a>
            </div>
            <a href="{{ url('/dashboard') }}" class="btn logout-btn" style="margin-top: 32px;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
