@extends('layouts.app')

@section('content')
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<div class="container">
    <h2>Payment Status for All Students</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Class</th>
                <th>Payment</th>
                <th>Approved</th>
            </tr>
        </thead>
        <tbody>
            @php $serial = 1; @endphp
            @foreach($students as $student)
                @php
                    $className = $student->class ? \DB::table('classes')->where('id', $student->class)->value('class') : '';
                @endphp
                @foreach($student->courses as $course)
                <tr>
                    <td>{{ $serial++ }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $className }}</td>
                    <td>{{ $course->payment ?? 'Pending' }}</td>
                    <td>
                        @if($course->payment === 'Success')
                            @if($course->approved === 'Yes')
                                Approved
                            @elseif($course->approved === 'Rejected')
                                Rejected
                            @else
                                <form action="{{ url('/courses/'.$course->id.'/approve') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ url('/courses/'.$course->id.'/approve') }}" method="POST" style="display:inline; margin-left:5px;">
                                    @csrf
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                        @else
                            Awaiting Payment
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <a href="{{ url('/dashboard') }}" class="btn btn-secondary" style="margin-top:20px;">Back to Dashboard</a>
</div>
@endsection
