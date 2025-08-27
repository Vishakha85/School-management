@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   @section('content')
 <link rel="stylesheet" href="{{ asset('css/login.css') }}">
<div class="container">
    <form>
        <h2>College Information for {{ ($student && $student->name) ? $student->name : 'N/A' }}</h2>
        @if($colleges && $colleges->count())
            @foreach($colleges as $college)
                @if($college)
                <div class="form-group">
                    <label>College Name:</label>
                    <input type="text" value="{{ $college->name ?? 'N/A' }}" readonly class="form-control">
                </div>
                <div class="form-group">
                    <label>Branch:</label>
                    <input type="text" value="{{ $college->branch ?? 'N/A' }}" readonly class="form-control">
                </div>
                <div class="form-group">
                    <label>Passout Year:</label>
                    <input type="text" value="{{ $college->passoutyear ?? 'N/A' }}" readonly class="form-control">
                </div>
                <hr>
                @endif
            @endforeach
        @else
            <div class="alert alert-warning">No college information found for this student.</div>
        @endif
        <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
@endsection
 
</body>
</html>