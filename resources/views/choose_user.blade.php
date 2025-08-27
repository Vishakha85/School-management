<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Choose User Type</title>
       
        <link rel="stylesheet" href="{{ asset('css/choose_user.css') }}">
</head>
<body>
    <div class="choose-container">
        <div class="outer-card">
            <h2>Choose User Type</h2>
            <div class="images-row">
                <div>
                    <img src="{{ asset('images/student-logo.jpg') }}" alt="Student">
                </div>
                <div>
                    <img src="{{ asset('images/portrait-standing-row-smiling-team-260nw-1721325904.jpg') }}" alt="Teacher">
                </div>
            </div>
            <div class="buttons-row">
               <a href="{{ route('students.create', ['role_id' => 2]) }}" class="choose-btn student">Student</a>
               <a href="{{ route('teachers.signup', ['role_id' => 3]) }}" class="choose-btn teacher">Teacher</a>
            </div>
        </div>
    </div>
</body>
</html>
