<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students Fee Structures</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <h2>All Students Fee Structures</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Annual Fee</th>
                <th>Tuition Fee</th>
                <th>Total Fee</th>
                <th>Fee Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                @php
                    $fee = $feeStructures[$student->class] ?? null;
                    $feeStatusRow = $feeStatuses[$student->id] ?? null;
                @endphp
                <tr @if(!$fee) style="background:#ffeaea;" @endif>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $fee->annual_fee ?? 'N/A' }}</td>
                    <td>{{ $fee->tuition_fee ?? 'N/A' }}</td>
                    <td>{{ $fee->total_fee ?? 'N/A' }}</td>
                    <td>
                        @role('admin')
                            @if($fee)
                                <form class="fee-status-form" data-student-id="{{ $student->id }}" style="display:inline;">
                                    @csrf
                                    <select name="fee_status" class="fee-status-select" data-student-id="{{ $student->id }}">
                                        <!-- ...existing code... -->
                                    </select>
                                </form>
                            @endif
                        @endrole
                                <option value="Pending" {{ ($feeStatusRow->fee_status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Success" {{ ($feeStatusRow->fee_status ?? 'Pending') == 'Success' ? 'selected' : '' }}>Success</option>
                            </select>
                            <span class="fee-status-msg" id="msg-{{ $student->id }}" style="color:green;font-size:12px;"></span>
                        </form>
                        @else
                            {{ $feeStatusRow->fee_status ?? 'Pending' }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ url('/dashboard') }}">Back to Dashboard</a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.fee-status-select').change(function() {
            var studentId = $(this).data('student-id');
            var feeStatus = $(this).val();
            var token = $('input[name="_token"]').first().val();
            var msgSpan = $('#msg-' + studentId);
            $.ajax({
                url: '/admin/fee-structures/update-status',
                type: 'POST',
                data: {
                    _token: token,
                    student_id: studentId,
                    fee_status: feeStatus
                },
                success: function(response) {
                    msgSpan.text('Updated!');
                    setTimeout(function(){ msgSpan.text(''); }, 1500);
                },
                error: function() {
                    msgSpan.text('Error!');
                    setTimeout(function(){ msgSpan.text(''); }, 2000);
                }
            });
        });
    });
    </script>
</body>
</html>
