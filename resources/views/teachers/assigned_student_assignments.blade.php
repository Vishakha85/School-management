@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<div class="container">
    <h2>Assigned Student Assignments</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Assignment Title</th>
                <th>Uploaded File</th>
                <th>Submission Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assignments as $assignment)
            <tr>
                <td>{{ $students[$assignment->std_id]->name ?? 'N/A' }}</td>
                    <td>{{ $assignmentTopics[$assignment->assignment_id] ?? 'N/A' }}</td>
                   <td>
                        @if($assignment->assignment)
                        <a href="{{ url('/teacher/assignment/' . $assignment->id . '/view') }}" class="btn btn-primary">View Assignment</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $assignment->created_at ? $assignment->created_at->format('d M Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="4">No assignments found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        <a href="{{ route('teacher.panel', ['id' => auth()->user()->id]) }}" class="btn btn-secondary">Back to Teacher Panel</a>
    </div>
</div>
@endsection
