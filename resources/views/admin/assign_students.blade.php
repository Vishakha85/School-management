<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Students to Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/assign_students.css') }}">
</head>
<body>
    <h2>Assign Students to {{ $teacher->name }}</h2>
    @if (!empty($success))
        <div style="color: green; margin-bottom: 10px;">{{ $success }}</div>
    @endif
    <h3>Assigned Students</h3>
    <table border="1" cellpadding="8" style="margin-bottom: 24px;">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @php $sn = 1; @endphp
            @forelse ($students as $student)
                @if (in_array($student->id, $assigned))
                    <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="3">No students assigned.</td>
                </tr>
            @endforelse
            @if (empty($assigned))
                <tr>
                    <td colspan="3">No students assigned.</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="assign-actions">
        <a href="#" id="openAssignModal" class="btn-assign">Assign Students</a>
        <a href="{{ url('/admin/view-teachers') }}" class="btn-assign">Back to Teachers List</a>
    </div>

    <div id="assignModal" class="assign-modal">
        <div class="assign-modal-content">
            <h3 class="assign-modal-title">Assign Students</h3>
            <form method="POST" action="{{ url('/admin/teachers/' . $teacher->id . '/assign-students') }}">
                @csrf
                <div class="assign-modal-table-wrap">
                    <table class="assign-modal-table" border="1" cellpadding="8">
                        <thead>
                            <tr>
                                <th class="sticky-header">Select</th>
                                <th class="sticky-header">Name</th>
                                <th class="sticky-header">Email</th>
                                <th class="sticky-header">Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td class="assign-modal-checkbox">
                                        <input type="checkbox" name="students[]" value="{{ $student->id }}" {{ in_array($student->id, $assigned) ? 'checked' : '' }}>
                                    </td>
                                    <td class="assign-modal-name">{{ $student->name }}</td>
                                    <td class="assign-modal-email">{{ $student->email }}</td>
                                    <td class="assign-modal-class">{{ $student->class_name ?? $student->class }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="assign-modal-actions">
                    <button type="submit" class="assign-modal-save">Save</button>
                    <button type="button" id="closeAssignModal" class="assign-modal-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('openAssignModal').onclick = function() {
            document.getElementById('assignModal').style.display = 'flex';
        };
        document.getElementById('closeAssignModal').onclick = function() {
            document.getElementById('assignModal').style.display = 'none';
        };
    </script>
</body>
</html>
