<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<h2>Welcome to the Admin Dashboard</h2>
<p>Logged in as: Admin</p>

<form method="GET" action="{{ route('dashboard') }}" class="dashboard-search-form">
    <input type="text" name="search" placeholder="Search students or colleges..." value="{{ $search ?? '' }}" style="padding:6px;width:250px;">
    <button type="submit" style="padding:6px 12px;">Search</button>
</form>

<table border="1" cellpadding="8">
@php
    $queryParams = request()->except('page');
@endphp


<thead>
    <tr>
        <th>S.No.</th>

        <th>
            Name
            <a href="{{ route('dashboard', array_merge($queryParams, ['sort' => 'name', 'direction' => 'asc'])) }}" >▲</a>
            <a href="{{ route('dashboard', array_merge($queryParams, ['sort' => 'name', 'direction' => 'desc'])) }}" style="text-decoration: none;">▼</a>
        </th>

        <th>
            Class
            <a href="{{ route('dashboard', array_merge($queryParams, ['sort' => 'class', 'direction' => 'asc'])) }}" style="margin-left: 5px; text-decoration: none;">▲</a>
            <a href="{{ route('dashboard', array_merge($queryParams, ['sort' => 'class', 'direction' => 'desc'])) }}" style="text-decoration: none;">▼</a>
        </th>

        <th>
            Number
            <a href="{{ route('dashboard', array_merge($queryParams, ['sort' => 'number', 'direction' => 'asc'])) }}" style="margin-left: 5px; text-decoration: none;">▲</a>
            <a href="{{ route('dashboard', array_merge($queryParams, ['sort' => 'number', 'direction' => 'desc'])) }}" style="text-decoration: none;">▼</a>
        </th>

        <th>
            About
        </th>

        <th>Actions</th>
    </tr>
</thead>
    <tbody>
        @forelse ($students as $student)
            <tr>
                <td>
                    @if(method_exists($students, 'currentPage'))
                        {{ $loop->iteration + (($students->currentPage() - 1) * $students->perPage()) }}
                    @else
                        {{ $loop->iteration }}
                    @endif
                </td>
                <td>{{ $student->name }}</td>
                <td>{{ \DB::table('classes')->where('id', $student->class)->value('class') }}</td>
                <td>{{ $student->number }}</td>
                <!-- <td>{{ $student->password }}</td> -->
                <!-- <td>
                    <span class="status {{ strtolower($student->status) === 'active' ? 'active' : 'inactive' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </td> -->
                <td>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <a href="{{ url('/students/' . $student->id . '/about') }}" class="btn-about">About</a>
                        <a href="{{ url('/admin/students/' . $student->id . '/fee-structure') }}" class="btn-fee-structure">View Fee Structure</a>
                    </div>
                </td>
              <td style="white-space: nowrap;">
    {{-- Delete Student --}}
    <form action="{{ url('/students/' . $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display: inline-block; margin-right: 8px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" style="padding: 6px 12px; background-color: #e53935; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Delete
        </button>
    </form>

    {{-- Login as Student (match by email in users table) --}}
    @php
        $user = \App\Models\User::where('email', $student->email)->first();
    @endphp

    @if ($user && $user->hasRole('student'))
        <form action="{{ route('admin.loginAsStudent', $user->id) }}" method="POST" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn-login" style="padding: 6px 12px; background-color: #1976d2; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Login as Student
            </button>
        </form>
    @else
        <span style="color:red;">User not found</span>
    @endif
</td>

            </tr>
        @empty
            <tr>
                <td colspan="8">No students found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
<div class="pagination-wrapper" style="display: flex; justify-content: center;">
    @if (method_exists($students, 'lastPage') && $students->lastPage() > 1)
        <ul class="pagination" style="display: flex; flex-wrap: nowrap; gap: 4px; align-items: center; list-style: none; padding: 0; margin: 0;">
            <li class="page-item{{ $students->onFirstPage() ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $students->previousPageUrl() ?? '#' }}">&laquo;</a>
            </li>
            @for ($i = 1; $i <= $students->lastPage(); $i++)
                <li class="page-item{{ $students->currentPage() == $i ? ' active' : '' }}">
                    <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item{{ $students->currentPage() == $students->lastPage() ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $students->nextPageUrl() ?? '#' }}">&raquo;</a>
            </li>
        </ul>
    @endif
</div>

{{-- Admin Dashboard Actions --}}
<div class="dashboard-actions">
    <a href="/logout">Logout</a>
    <a href="{{ url('/students/addstudent') }}" class="btn-add">Add New Student</a>
    @role('admin')
        <a href="{{ url('/admin/emails') }}" class="btn-view-emails">View Emails</a>
        <a href="{{ url('/admin/assignments-classes') }}" class="btn-add-assignments">Add Assignments</a>
        <a href="{{ url('/admin/view-assignments') }}" class="btn-view-assignments">View Assignments</a>
        <a href="{{ url('/students/payment-status') }}" class="btn-payment-status">View Payment Status</a>
        <a href="{{ url('/admin/view-teachers') }}" class="btn-view-teachers">View Teachers</a>
        {{-- <a href="{{ url('/admin/view-all-teachers') }}" class="btn btn-primary">Switch Teachers Role to Students</a> --}}
    @else
        <button class="btn-view-emails" onclick="alert('Access denied. Please login as admin.\nAdmin credentials:\nUsername: admin\nPassword: password123'); return false;">View Emails</button>
        <button class="btn-add-assignments" onclick="alert('Access denied. Please login as admin.\nAdmin credentials:\nUsername: admin\nPassword: password123'); return false;">Add Assignments</button>
        <button class="btn-view-assignments" onclick="alert('Access denied. Please login as admin.\nAdmin credentials:\nUsername: admin\nPassword: password123'); return false;">View Assignments</button>
        <button class="btn-payment-status" onclick="alert('Access denied. Please login as admin.\nAdmin credentials:\nUsername: admin\nPassword: password123'); return false;">View Payment Status</button>
    @endrole
</div>

</body>
</html>
