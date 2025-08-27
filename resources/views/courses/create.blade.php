@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Course Details</h2>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student_id ?? '' }}">
        <div class="form-group">
            <label for="class">Class</label>
            @php
                $classId = $student ? $student->class : null;
                $className = $classId ? \DB::table('classes')->where('id', $classId)->value('class') : '';
            @endphp
            <input type="text" class="form-control" value="{{ $className }}" readonly>
            <input type="hidden" name="class" value="{{ $classId }}">
        </div>
        @php
            $fee = null;
            if(isset($classId) && $classId) {
                $fee = \App\Models\FeeStructure::where('course_id', $classId)->first();
            }
            $coreSubjects = [
                'B.Tech' => 'Engineering',
                'Mtech' => 'Advanced Engineering',
                'MCA' => 'Computer Applications',
                'BCA' => 'Computer Applications',
                'BCOM' => 'Commerce',
                'PHD' => 'Research',
            ];
            $durations = [
                'B.Tech' => '4 Years',
                'Mtech' => '2 Years',
                'MCA' => '3 Years',
                'BCA' => '3 Years',
                'BCOM' => '3 Years',
                'PHD' => 'Variable',
            ];
        @endphp
        <div id="fee-details">
            <div class="form-group">
                <label>Annual Fee</label>
                <input type="text" id="annual_fee" class="form-control" value="{{ $fee ? $fee->annual_fee : '' }}" >
            </div>
            <div class="form-group">
                <label>Tuition Fee</label>
                <input type="text" id="tuition_fee" class="form-control" value="{{ $fee ? $fee->tuition_fee : '' }}" >
            </div>
            <div class="form-group">
                <label>Total Fee</label>
                <input type="text" id="total_fee" class="form-control" value="{{ $fee ? $fee->total_fee : '' }}" >
            </div>
            <div class="form-group">
                <label for="core_subject">Core Subject</label>
                <input type="text" name="core_subject" id="core_subject" class="form-control" value="{{ $coreSubjects[$className] ?? '' }}" >
            </div>
            <div class="form-group">
                <label for="duration">Duration of the Course</label>
                <input type="text" name="duration" id="duration" class="form-control" value="{{ $durations[$className] ?? '' }}" >
            </div>
            <div class="form-group">
                <label for="want_to_enroll">Want to Enroll Course</label>
                <button type="submit" class="btn btn-success" name="want_to_enroll" value="1">Pay</button>
            </div>
        </div>

        @php
        $studentName = $student ? $student->name : '';
        $courseStatus = null;
            if(isset($student)) {
                $courseStatus = $student->courses()->orderByDesc('id')->first();
            }
            $isPaid = $courseStatus && $courseStatus->payment === 'Success';
            $isApproved = $courseStatus && $courseStatus->approved === 'Yes';
        @endphp
        <div class="form-group" style="margin-top:20px;">
            <a href="{{ $isPaid && $isApproved ? url('/login') : '#' }}" class="btn btn-info @if(!$isPaid || !$isApproved) disabled @endif" @if(!$isPaid || !$isApproved) tabindex="-1" aria-disabled="true" @endif>
                @if($isPaid && $isApproved)
                    Request is approved
                @elseif($isPaid && !$isApproved && $courseStatus && $courseStatus->approved === 'Rejected' && $courseStatus->payment === 'Success')
                    Enrollment is rejected by admin. Please <a href="{{ url('/students/create') }}">signup again</a>.
                @elseif($isPaid && !$isApproved)
                    Waiting for admin approval...
                @else
                    Please pay to proceed
                @endif
            </a>
            <a href="{{ route('student.studentdash') }}" class="btn btn-secondary" style="margin-left:10px;">Back to Dashboard</a>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#class').change(function() {
        var selectedClass = $(this).val();
        if(selectedClass) {
            $.ajax({
                url: '{{ url('courses/fetch-details') }}',
                type: 'POST',
                data: {
                    class: selectedClass,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if(data) {
                        $('#annual_fee').val(data.annual_fee);
                        $('#tuition_fee').val(data.tuition_fee);
                        $('#total_fee').val(data.total_fee);
                        $('#fee-details').show();
                    }
                }
            });
        } else {
            $('#fee-details').hide();
        }
    });
});
</script>
@endsection 

@if(isset($successMessage))
    <div class="alert alert-success">{{ $successMessage }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif