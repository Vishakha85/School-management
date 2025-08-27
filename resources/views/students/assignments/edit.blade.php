@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/editpage.css') }}">
    <div class="assignment-edit-wrapper">
        <div class="assignment-edit-card">
            <div class="card-header">
                <h2>Edit Uploaded Assignment</h2>
            </div>

            <form action="{{ route('students.assignments_update', [$assignment->std_id, $assignment->assignment_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- @method('PUT') -->

                <div class="form-group">
                    <label>Assignment Topic</label>
                    <p>{{ $assignmentMeta->assignment_topic ?? 'N/A' }}</p>
                </div>
<!-- 
                <div class="form-group">
                    <label>Assignment ID</label>
                    <p>{{ $assignment->assignment_id }}</p>
                </div> -->

                <div class="form-group">
                    <label>Uploaded File</label>
                    @if($assignment->assignment)
                        <a href="{{ asset('storage/' . $assignment->assignment) }}" >View File</a>
                    @else
                        <p>No file uploaded.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="assignment">Upload New File</label>
                    <input type="file" name="assignment" id="assignment" class="input-file" required>
                    @error('assignment')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Upload & Replace</button>
                    <a href="{{ route('students.assignments', ['id' => $assignment->std_id]) }}" class="btn-secondary">Back to Assignments</a>
                </div>
            </form>
        </div>
    </div>
@endsection
