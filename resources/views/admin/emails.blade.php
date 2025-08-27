@extends('layouts.app')
@section('content')
     <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<div class="container">
    @role('admin')
        <h2>Sent Emails</h2>
        <table border="1" cellpadding="8" style="width:100%;margin-top:20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Student ID</th> -->
                    <th>To</th>
                    <th>Subject</th>
                    <th>Student Name</th>
                    <th>Changes</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emails as $email)
                    <tr>
                        <td>{{ $email->id }}</td>
                        <!-- <td>{{ $email->student_id ?? 'N/A' }}</td> -->
                        <td>{{ $email->recipient }}</td>
                        <td>{{ $email->subject }}</td>
                        <td>{{ $email->student_name ?? 'N/A' }}</td>
                        <td>
                            @if($email->changes_summary)
                                <ul style="margin:0;padding-left:15px;">
                                    @foreach(explode(',', $email->changes_summary) as $change)
                                        <li>{{ $change }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <!-- ...existing code... -->
                            @endif
                        </td>
                        <td>{{ $email->created_at }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">No emails found.</td></tr>
                @endforelse
            </tbody>
        </table>
    @else
        <div style="color: red; font-weight: bold;">Access denied. Please login as admin to access this page.</div>
        <a href="{{ url('/login') }}">Login</a> 
    @endrole
    <a href="{{ url('/dashboard') }}" class="btn-add" style="display:inline-block;margin-top:20px;">Back to Dashboard</a>
</div>
@endsection
