<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Panel</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .teacher-panel {
            display: flex;
            align-items: center;
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .teacher-image {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 32px;
            background: #eee;
            border: 2px solid #1976d2;
        }
        .teacher-details {
            flex: 1;
        }
        .teacher-details h3 {
            margin: 0 0 12px 0;
            font-size: 1.5em;
        }
        .teacher-details p {
            margin: 6px 0;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="teacher-panel">
        @if($teacher && $teacher->image)
            <img src="{{ asset('storage/' . $teacher->image) }}" alt="Teacher Image" class="teacher-image">
        @else
            <div class="teacher-image"></div>
        @endif
        <div class="teacher-details">
            <h3>{{ $teacher->name }}</h3>
            <p><strong>Experience:</strong> {{ $teacher->experience }}</p>
            <p><strong>Department:</strong> {{ \DB::table('classes')->where('id', $teacher->department)->value('class') ?? 'N/A' }}</p>
            <a href="{{ url('/teacher/' . $teacher->id . '/assigned-students') }}" class="btn-view-assigned-students" style="display:inline-block;margin-top:18px;padding:8px 16px;background:#1976d2;color:#fff;border-radius:5px;text-decoration:none;">View Assigned Students</a>
            <a href="{{ url('/teacher/' . $teacher->id . '/assigned-student-assignments') }}" class="btn-view-assignments" style="display:inline-block;margin-top:10px;padding:8px 16px;background:#388e3c;color:#fff;border-radius:5px;text-decoration:none;margin-left:12px;">View Student Assignments</a>
           @if(!session()->has('impersonated_by'))
    <a href="/logoutteacher" class="btn btn-danger logout-btn" style="display:inline-block;margin-top:18px;padding:8px 16px;background:#1976d2;color:#fff;border-radius:5px;text-decoration:none;">Logout</a>
@endif

          @if (session('impersonated_by'))
                    <form action="{{ route('revert.login') }}" method="POST" style="display:inline;">
                                 @csrf
                                <button type="submit" class="btn-revert-login">Return to Admin</button>
                                     </form>
                                @endif  
        </div>
    </div>
</body>
</html>
