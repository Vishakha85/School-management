@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Assignment Details</h2>
    <p><strong>Student Name:</strong> {{ $student->name ?? 'N/A' }}</p>
    <p><strong>Assignment Topic:</strong> {{ $assignmentTopic ?? 'N/A' }}</p>
    <div style="margin:20px 0;">
        <strong>Assignment Content:</strong><br>
        @if($assignment->assignment)
            <iframe src="{{ asset('storage/' . $assignment->assignment) }}" width="100%" height="400px"></iframe>
        @else
            <p>N/A</p>
        @endif
    </div>
    <form method="POST" action="{{ route('teacher.assignment.check', ['id' => $assignment->id]) }}">
        @csrf
        <label for="marks">Marks:</label>
        <input type="number" name="marks" id="marks" min="0" max="100" required>
        <br><br>
        <label for="summary">Review Summary:</label>
        <textarea name="summary" id="summary" rows="4" style="width:100%;" placeholder="Enter review summary here..."></textarea>
        <button type="submit" class="btn btn-success" style="margin-left:10px;">Checked</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success" style="margin-top:15px;">{{ session('success') }}</div>
    @endif
    <a href="{{ route('teacher.assigned_student_assignments', ['teacherId' => $teacherId]) }}" class="btn btn-secondary" style="margin-top:20px;">Back</a>
</div>
@endsection
