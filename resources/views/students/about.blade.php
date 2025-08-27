@extends('layouts.app')
@section('content')

<style>
    .college-details-container {
        max-width: 500px;
        margin: 40px auto;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px #0001;
        padding: 30px;
    }
    .college-details-container h2 {
        margin-bottom: 18px;
        color: #1976d2;
        font-size: 1.3em;
        font-weight: 600;
    }
    .college-details-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 18px;
        background: #f9fafb;
        border-radius: 8px;
        overflow: hidden;
    }
    .college-details-table th {
        background: #f5f5f5;
        color: #333;
        font-weight: 500;
        padding: 10px 8px;
        border: none;
        text-align: left;
        font-size: 1em;
        letter-spacing: 0.5px;
    }
    .college-details-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #e0e0e0;
        font-size: 0.98em;
        background: #fff;
    }
    .college-details-table tr:last-child td {
        border-bottom: none;
    }
    .btn-secondary {
        display: inline-block;
        padding: 8px 18px;
        background: #1976d2;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-secondary:hover {
        background: #115293;
    }
</style>
<div class="college-details-container">
    <h2>College Details</h2>
    @php
        $college = $student->college ?? ($student->colleges->first() ?? null);
    @endphp
    <table class="college-details-table">
        @if($college)
            <tr><th>College Name</th><td>{{ $college->name }}</td></tr>
            <tr><th>Branch</th><td>{{ $college->branch }}</td></tr>
            <tr><th>Passout Year</th><td>{{ $college->passoutyear }}</td></tr>
        @else
            <tr><td colspan="2">No college details found for this student.</td></tr>
        @endif
    </table>
    <a href="{{ url('/dashboard') }}" class="btn-secondary" style="margin-top:20px;">Back to Dashboard</a>
 
</div>
@endsection
