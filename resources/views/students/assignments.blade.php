@php
    $studentId = request()->route('id');
    $student = \App\Models\student::find($studentId);
    $courseId = $student ? $student->class : null; // class now stores class id
    $className = null;
    $assignments = collect();
    if ($courseId) {
        $assignments = \DB::table('assignments')->where('course_id', $courseId)->get();
        $className = \DB::table('classes')->where('id', $courseId)->value('class');
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <link rel="stylesheet" href="{{ asset('css/studentdashboard.css') }}">
    <style>
        .form-box.card {
            min-width: 500px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- <p>Course ID: <strong>{{ $courseId ?? 'N/A' }}</strong></p> -->
        <!-- <div class="form-box card"> -->
            <h2>{{ $className ? $className . ' Assignments' : 'Assignments' }}</h2>
            @if(isset($assignments) && count($assignments) > 0)
            <table class="table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="border:1px solid #ccc;padding:8px;">S.No.</th>
                        <th style="border:1px solid #ccc;padding:8px;">Title</th>
                        <th style="border:1px solid #ccc;padding:8px;">Question</th>
                        <th style="border:1px solid #ccc;padding:8px;">Description</th>
                        <th style="border:1px solid #ccc;padding:8px;">Upload Assignment</th>
                        <th style="border:1px solid #ccc;padding:8px;">Teacher Reviews</th>
                        <th style="border:1px solid #ccc;padding:8px;">Edit Assignment</th>
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
                        <td style="border:1px solid #ccc;padding:8px;">
                            @php
                                $review = null;
                                // Find review for this assignment and student through student_teacher_id
                                $studentTeacherRow = \DB::table('student_teacher')
                                    ->where('student_id', $studentId)
                                    ->first();
                                if ($studentTeacherRow) {
                                    $reviewRow = \DB::table('assignment_reviews')
                                        ->where('student_teacher_id', $studentTeacherRow->id)
                                        ->where('assignment_id', $assignment->id)
                                        ->first();
                                    if ($reviewRow) {
                                        $review = $reviewRow;
                                    }
                                }
                            @endphp
                            @if($review)
                                <a href="#" onclick="showReviewModal('{{ $review->marks }}', '{{ addslashes($review->summary) }}'); return false;">View Review</a>
                            @else
                                <span style="color:#888;">No Review</span>
                            @endif
                        </td>
                        <td style="border:1px solid #ccc;padding:8px;">
                            @php
                                // Check if student has already uploaded for this assignment
                                $uploaded = isset($uploadedAssignmentsArr[$assignment->id]);
                            @endphp
                            <form action="{{ route('assignments.upload', $studentId) }}" method="POST" enctype="multipart/form-data" style="margin:0;">
                                @csrf
                                <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                <input type="file" name="assignment_file" accept=".pdf,.txt" required @if($uploaded) disabled @endif>
                                <button type="submit" style="margin-left: 10px;" @if($uploaded) disabled @endif>Upload</button>
                                <p>Accepted file types: PDF, TXT</p>
                                @if($uploaded)
                                    <span style="color: #1976d2; font-size: 0.95em;">Uploaded Successfully</span>
                                @endif
                            </form>
                        </td>
                        <td style="border:1px solid #ccc;padding:8px;">
                            @if($review)
                              <a href="{{ route('students.assignments_edit', ['studentId' => $studentId, 'assignmentId' => $assignment->id]) }}">Edit</a>

                            @else
                                <span style="color:#888;">No Review</span>
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <h3>No assignments available for this course.</h3>
            @endif
        <!-- Description Modal -->
        <div id="descModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:9999;align-items:center;justify-content:center;">
            <div style="background:#fff;padding:24px 32px;border-radius:8px;max-width:500px;margin:auto;box-shadow:0 2px 8px rgba(0,0,0,0.2);position:relative;">
                <h4 style="margin-top:0;">Assignment Description</h4>
                <div id="descModalContent" style="margin-bottom:16px;white-space:pre-line;"></div>
                <button onclick="closeDescModal()" style="background:#1976d2;color:#fff;border:none;padding:8px 18px;border-radius:4px;cursor:pointer;">Close</button>
            </div>
        </div>
        <!-- Teacher Review Modal -->
        <div id="reviewModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:9999;align-items:center;justify-content:center;">
            <div style="background:#fff;padding:24px 32px;border-radius:8px;max-width:500px;margin:auto;box-shadow:0 2px 8px rgba(0,0,0,0.2);position:relative;">
                <h4 style="margin-top:0;">Teacher Review</h4>
                <div id="reviewModalContent" style="margin-bottom:16px;white-space:pre-line;"></div>
                <button onclick="closeReviewModal()" style="background:#1976d2;color:#fff;border:none;padding:8px 18px;border-radius:4px;cursor:pointer;">Close</button>
            </div>
        </div>
        <script>
            function showDescModal(desc) {
                document.getElementById('descModalContent').innerText = desc || 'No description available.';
                document.getElementById('descModal').style.display = 'flex';
            }
            function closeDescModal() {
                document.getElementById('descModal').style.display = 'none';
            }
            function showReviewModal(marks, summary) {
                var content = '<strong>Marks:</strong> ' + (marks || 'N/A') + '<br><strong>Summary:</strong> ' + (summary || 'N/A');
                document.getElementById('reviewModalContent').innerHTML = content;
                document.getElementById('reviewModal').style.display = 'flex';
            }
            function closeReviewModal() {
                document.getElementById('reviewModal').style.display = 'none';
            }
        </script>
        <!-- </div> -->
        <a href="{{ url('/students/studentdash') }}" class="btn logout-btn">Back</a>
    </div>
</body>
</html>
