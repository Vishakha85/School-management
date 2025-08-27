@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/fee_structure.css') }}">
<div class="fee-structure-container">
    <h2>Fee Structure Details</h2>
    <form>
        <label>Student ID:</label>
        <input type="text" value="{{ $student->id }}" disabled><br>
        <label>Class:</label>
        <input type="text" value="{{ $className ?? '' }}" disabled><br>
        <label>Annual Fee:</label>
        <input type="text" value="{{ $feeStructure->annual_fee ?? '' }}" disabled><br>
        <label>Tuition Fee:</label>
        <input type="text" value="{{ $feeStructure->tuition_fee ?? '' }}" disabled><br>
        <label>Per Sem Fee:</label>
        <input type="text" value="{{ $feeStructure->per_sem_fee ?? '' }}" disabled><br>
        <label>Total Fee:</label>
        <input type="text" value="{{ $feeStructure->total_fee ?? '' }}" disabled><br>
        <label>Fee Status:</label>
        <input type="text" value="{{ $feeStatus ?? 'Pending' }}" disabled><br>
        <a href="{{ url('/students/studentdash') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
