<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/studentdashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        @role('student')
            <div class="dashboard-header">
                <h2>Welcome to the Student Dashboard</h2>
                @if(count($students) > 0)
                    @php $student = $students[0]; @endphp
                    <div class="student-profile-container">
                        <div class="student-profile-image">
                            @if(!empty($student->image) && file_exists(public_path('storage/' . $student->image)))
                                <img src="{{ asset('storage/' . $student->image) }}" alt="Profile Image">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile">
                            @endif
                        </div>
                        <div class="student-info-container">
                            <div class="student-info-row">
                                <div class="student-id">Student ID: <span>{{ $student->id }}</span></div>
                                <div class="student-name">Name: <span>{{ $student->name }}</span></div>
                            </div>
                            <div class="student-info-row2">
                                <div class="student-email">Email: <span>{{ optional(\App\Models\User::where('name', $student->name)->first())->email ?? 'N/A' }}</span></div>
                                <div class="assigned-teacher">Assigned Teacher: <span>{{ optional($student->teachers()->first())->name ?? 'N/A' }}</span></div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
                @endif
            </div>

            @if(count($students) > 0)
                @php $student = $students[0]; @endphp
                <div class="forms-row">
                    <div class="form-box card">
                        <h3>Student Details</h3>
                        <div class="form-group"><label>Class:</label><input type="text" value="{{ \DB::table('classes')->where('id', $student->class)->value('class') }}" readonly></div>
                        <div class="form-group"><label>Number:</label><input type="text" value="{{ $student->number }}" readonly></div>
                        <div class="form-group"><label>Age:</label><input type="text" value="{{ $student->age }}" readonly></div>
                        <a href="/students/{{ $student->id }}/edit" class="edit-btn"><button type="button">Edit</button></a>
                    </div>

                    <div class="form-box card">
                        <h3>College Information</h3>
                        @if(isset($colleges) && count($colleges) > 0)
                            @foreach($colleges as $college)
                                @if($college)
                                    <div class="form-group"><label>College Name:</label><input type="text" value="{{ $college->name ?? 'N/A' }}" readonly></div>
                                    <div class="form-group"><label>Branch:</label><input type="text" value="{{ $college->branch ?? 'N/A' }}" readonly></div>
                                    <div class="form-group"><label>Passout Year:</label><input type="text" value="{{ $college->passoutyear ?? 'N/A' }}" readonly></div>
                                    @if(isset($college->id))
                                    <a href="{{ route('colleges.edit', $college->id) }}" class="edit-btn"><button type="button">Edit</button></a>
                                    @endif
                                    @endif
                                    @endforeach
                                    @else
                                    <div class="no-data">No college information found.</div>
                                    @endif
                                    @if(isset($feeStatus) && strtolower($feeStatus) === 'success')
                                        <a href="/students/{{ $student->id }}/fee-structure" class="edit-btn"><button type="button">View Fee Structure</button></a>
                                        <a href="{{ route('students.assignments', $student->id) }}" class="edit-btn"><button type="button">Assignment</button></a>
                                    @else
                                        <a href="{{ route('courses.create', ['student_id' => $student->id]) }}" class="edit-btn"><button type="button">Enroll Course</button></a>
                                    @endif
                                    @if(empty($colleges) || count($colleges) == 0)
                                        <a href="{{ route('colleges.create', ['std_id' => $student->id]) }}" class="edit-btn"><button type="button">Add college Details</button></a>
                                    @endif
                                </div>
                                 @if(!session()->has('impersonated_by'))
                                <a href="/logoutstd" class="btn btn-danger logout-btn">Logout</a>
                                @endif
                              @if (session('impersonated_by'))
                    <form action="{{ route('revert.login') }}" method="POST" style="display:inline;">
                                 @csrf
                                <button type="submit" class="btn-revert-login">Return to Admin</button>
                                     </form>
                                @endif

                                @endif
                                @else
                                <div style="color: red; font-weight: bold;">
                Access denied. Please <a href="{{ url('/login') }}">login as student</a> to access this page.
            </div>
        @endrole
    </div>
</body>
</html>
