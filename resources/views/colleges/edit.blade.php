@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <div class="container">
        @role('student')
            <form action="{{ route('colleges.update', $college->id) }}" method="POST">
                <h2>Edit College Information for {{ $college->student ? $college->student->name : 'N/A' }}</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">College Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $college->name }}" required>
                </div>
                <div class="form-group">
                    <label for="branch">Branch</label>
                    <input type="text" name="branch" id="branch" class="form-control" value="{{ $college->branch }}" required>
                </div>
                <div class="form-group">
                    <label for="passoutyear">Passout Year</label>
                    <input type="text" name="passoutyear" id="passoutyear" class="form-control" value="{{ $college->passoutyear }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('/students/studentdash') }}" class="btn btn-secondary">Back</a>
            </form>
        @else
            <div style="color: red; font-weight: bold;">
                Access denied. Please login as student to access this page.
            </div>
            <a href="{{ url('/login') }}">Login</a>
        @endrole
    </div>
@endsection
