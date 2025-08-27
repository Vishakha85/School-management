<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <h2>All Teachers</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Experience</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teachers as $teacher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->experience }}</td>
                    <td>{{ $teacher->department_name ?? $teacher->department }}</td>
                    <td>
                        <a href="{{ url('/admin/teachers/' . $teacher->id . '/assign-students') }}" class="btn-assign-students">Assign Students</a>
                        <a href="{{ url('/login-as-teacher/' . $teacher->id) }}" class="btn-login-as-teacher">Login as Teacher</a>
              <form action="{{ url('/admin/teachers/' . $teacher->id . '/shift-to-student') }}" method="POST" style="display:inline;">
                        @csrf
                  <button type="submit" class="btn-shift-to-teacher">Shift to Student</button>
    </form>
      </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No teachers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        <a href="{{ url('/dashboard') }}" class="btn-back">Back to Dashboard</a>
    </div>
</body>
</html>
