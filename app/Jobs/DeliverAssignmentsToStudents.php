<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Assignment;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AssignmentDelivered;


class DeliverAssignmentsToStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

public function handle(): void
{
    $now = Carbon::now();

    Log::info("Running assignment delivery job at: " . $now->toDateTimeString());

    $assignments = Assignment::where('release_time', '<=', $now)->get();

    if ($assignments->isEmpty()) {
        Log::info("No assignments found to deliver at this time.");
        return;
    }

    foreach ($assignments as $assignment) {
        Log::info("Delivering assignment ID {$assignment->id}");
        $students = Student::where('class', $assignment->course_id)->get();
        foreach ($students as $student) {
            Mail::to($student->email)->queue(new AssignmentDelivered($assignment, $student));
            Log::info("Email sent to student ID {$student->id} ({$student->email}) for assignment ID {$assignment->id}");
        }
        $assignment->touch();
    }
    Log::info("Total assignments delivered: " . $assignments->count());
}

}

