@component('mail::message')
# College Information Edited

The following college information has been updated for student:

- **Student Name:** {{ $studentName }}
- **Student ID:** {{ $studentId }}
- **College Name:** {{ $collegeName }}
- **Edit Time:** {{ $editTime }}

## Edited Fields
@if(count($editedFields) > 0)
<ul>
@foreach($editedFields as $field)
    <li>{{ ucfirst($field) }}</li>
@endforeach
</ul>
@else
No fields were changed.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
