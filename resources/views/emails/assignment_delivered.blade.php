<h2>Hello {{ $student->name }},</h2>

<p>A new assignment has been released for your class:</p>

<strong>Topic:</strong> {{ $assignment->assignment_topic }}<br>
<strong>Question:</strong> {{ $assignment->assignment_question }}<br>
<strong>Description:</strong> {{ $assignment->assignment_description }}

<p>Please check the portal to complete the assignment.</p>

<p>Thanks,<br>Faculty Team</p>
