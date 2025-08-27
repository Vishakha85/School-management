@extends('layouts.app')

@section('content')
   <link rel="stylesheet" href="{{ asset('css/login.css') }}">
<div class="container">
    <h2>College Information</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('colleges.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="student_name">Student</label>
            <input type="text" name="student_name" id="student_name" class="form-control" value="{{ $student ? $student->name : '' }}" readonly>
            <input type="hidden" name="std_id" value="{{ $std_id }}">
        </div>
        <div class="form-group">
            <label for="name">College Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="branch">Branch</label>
            <input type="text" name="branch" id="branch" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="passoutyear">Passout Year</label>
            <input type="number" name="passoutyear" id="passoutyear" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
