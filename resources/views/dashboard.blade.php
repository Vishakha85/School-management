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
    <p>Logged in as: {{ session('username') }}</p>

 
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Number</th>
                <th>Age</th>
                <th>Password</th>
                <th>Status</th>
                  <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->number }}</td>
                    <td>{{ $student->age }}</td>
                     <td>{{ $student->password }}</td>
                    <td>
              <span class="status {{ strtolower($student->status) === 'active' ? 'active' : 'inactive' }}">
                {{ ucfirst($student->status) }}
                </span>
               </td>
               <td>
                     <form action="{{ url('/students/' . $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin: 20px 0;">
        <div class="pagination-wrapper" style="display: flex; justify-content: center;">
            @if ($students->lastPage() > 1)
                <ul class="pagination" style="display: flex; flex-wrap: nowrap; gap: 4px; align-items: center; list-style: none; padding: 0; margin: 0;">
                    {{-- Previous Page Link --}}
                    <li class="page-item{{ $students->onFirstPage() ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $students->previousPageUrl() ?? '#' }}" tabindex="-1">&laquo;</a>
                    </li>
                    {{-- Pagination Elements --}}
                    @for ($i = 1; $i <= $students->lastPage(); $i++)
                        <li class="page-item{{ $students->currentPage() == $i ? ' active' : '' }}">
                            <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Next Page Link --}}
                    <li class="page-item{{ $students->currentPage() == $students->lastPage() ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $students->nextPageUrl() ?? '#' }}">&raquo;</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
    <a href="/logout">Logout</a>
    @if(session('is_admin'))
        <a href="{{ url('/students/addstudent') }}" class="btn-add">Add New Student</a>
    @endif
</body>
</html>
