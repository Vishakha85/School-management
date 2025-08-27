<!DOCTYPE html>
<html>
<head>
    <title>Student Information Updated</title>
</head>
<body>
    <h2>Student Information Updated</h2>
    <p>The following student has updated their information:</p>
    <ul>
        <li><strong>Name:</strong> {{ $student->name }}</li>
        <li><strong>Class:</strong> {{ $student->class }}</li>
        <li><strong>Number:</strong> {{ $student->number }}</li>
        <li><strong>Age:</strong> {{ $student->age }}</li>
    </ul>
    <h3>Changes:</h3>
    <ul>
        @foreach($changes as $field => $change)
            <li><strong>{{ ucfirst($field) }}:</strong> {{ $change['old'] }} → {{ $change['new'] }}</li>
        @endforeach
    </ul>
</body>
</html>
