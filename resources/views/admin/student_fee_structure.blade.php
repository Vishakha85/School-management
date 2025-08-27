@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin_fee_structure.css') }}">
<h2>Student Fee Structure (Admin View)</h2>
<form method="POST" action="{{ url('/admin/students/' . $student->id . '/fee-structure') }}">
    @csrf
    @method('PUT')
    <label>Student ID:</label>
    <input type="text" value="{{ $student->id }}" disabled><br>
    <label>Class:</label>
    <input type="text" value="{{ $className ?? '' }}" disabled><br>
    <label>Annual Fee:</label>
    <input type="text" value="{{ $feeStructure->annual_fee ?? '' }}" disabled><br>
    <label>Tuition Fee:</label>
    <input type="text" value="{{ $feeStructure->tuition_fee ?? '' }}" disabled><br>
    <label>Total Fee:</label>
    <input type="text" value="{{ $feeStructure->total_fee ?? '' }}" disabled><br>
    <label>Fee Status:</label>
    <input type="text" value="{{ $feeStatus ?? 'Pending' }}" disabled><br>
    <a href="{{ url('/dashboard') }}" class="btn btn-secondary" style="margin-left:10px;">Back</a>
</form>
@endsection
