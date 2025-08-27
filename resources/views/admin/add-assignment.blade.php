<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assignment - B.Tech</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/add-assignment.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <div class="assignment-box">
            <h2>Add Assignment</h2>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('admin.assignments.store', ['course_id' => $course->course_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="assignment_topic">Assignment Topic</label>
                    <input type="text" name="assignment_topic" id="assignment_topic" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="assignment_question">Assignment Question</label>
                    <input type="text" name="assignment_question" id="assignment_question" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="assignment_description">Assignment Description</label>
                    <textarea name="assignment_description" id="assignment_description" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Assignment</button>
            </form>
            @if(isset($assignments) && count($assignments) > 0)
            <div style="margin-top:40px;">
                <h3>Assignments</h3>
                <table class="table" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="border:1px solid #ccc;padding:8px;">S.No.</th>
                            <th style="border:1px solid #ccc;padding:8px;">Title</th>
                            <th style="border:1px solid #ccc;padding:8px;">Question</th>
                            <th style="border:1px solid #ccc;padding:8px;">Description</th>
                            <th style="border:1px solid #ccc;padding:8px;">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $i => $assignment)
                        <tr>
                            <td style="border:1px solid #ccc;padding:8px;">{{ $i + 1 }}</td>
                            <td style="border:1px solid #ccc;padding:8px;">{{ $assignment->assignment_title ?? $assignment->assignment_topic }}</td>
                            <td style="border:1px solid #ccc;padding:8px;">{{ $assignment->assignment_question }}</td>
                            <td style="border:1px solid #ccc;padding:8px;">
                                <a href="#" onclick="showDescModal('{{ addslashes($assignment->assignment_description) }}'); return false;">Desc</a>
                            </td>
                            <td style="border:1px solid #ccc;padding:8px;">{{ $assignment->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <a href="{{ url('/admin/assignments-classes') }}" class="btn logout-btn" style="margin-top: 32px;">Back to Class Selection</a>
        </div>
    </div>

    <!-- Modal for Description -->
    <div id="descModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:#fff;padding:28px 24px;border-radius:10px;max-width:500px;margin:120px auto;box-shadow:0 2px 8px #0002;position:relative;">
            <h3 style="margin-top:0;margin-bottom:12px;color:#1976d2;font-size:1.1em;">Assignment Description</h3>
            <div id="descContent" style="font-size:1em;color:#333;white-space:pre-line;"></div>
            <button onclick="closeDescModal()" style="margin-top:18px;padding:8px 18px;background:#1976d2;color:#fff;border:none;border-radius:5px;cursor:pointer;">Close</button>
        </div>
    </div>
    <script>
        function showDescModal(desc) {
            document.getElementById('descContent').textContent = desc;
            document.getElementById('descModal').style.display = 'flex';
        }
        function closeDescModal() {
            document.getElementById('descModal').style.display = 'none';
        }
        // Close modal on outside click
        document.addEventListener('click', function(e) {
            var modal = document.getElementById('descModal');
            if (modal.style.display === 'flex' && e.target === modal) {
                closeDescModal();
            }
        });
    </script>
</body>
</html>
