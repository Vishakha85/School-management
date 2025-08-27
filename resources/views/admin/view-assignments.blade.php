<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
     
</head>
<body>
    <h2>All Student Assignments</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Student Name</th>
                <th>Assignment Topic</th>
                <th>Assignment File</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($studentAssignments as $i => $assignment)
                @php
                    $studentName = \DB::table('students')->where('id', $assignment->std_id)->value('name');
                    $assignmentTopic = \DB::table('assignments')->where('id', $assignment->assignment_id)->value('assignment_topic');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $studentName }}</td>
                    <td>{{ $assignmentTopic }}</td>
                    <td>
                        @if($assignment->assignment)
                            <a href="{{ asset('storage/' . $assignment->assignment) }}" >Preview</a>
                           
                            <a href="{{ asset('storage/' . $assignment->assignment) }}" download>Download</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No assignments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br>
    <a href="{{ url('/dashboard') }}" style="display:inline-block;padding:8px 18px;background:#1976d2;color:#fff;border-radius:5px;text-decoration:none;">Back to Dashboard</a>
</body>
</html>
