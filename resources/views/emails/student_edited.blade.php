<x-mail::message>
# Student Information Edited

Student <strong>{{ $studentName }}</strong> edited their information.

<strong>Time:</strong> {{ $editTime }}

@if(!empty($editedFields))
<strong>Edited Fields:</strong>
<ul>
@foreach($editedFields as $field)
<li>{{ $field }}</li>
@endforeach
</ul>
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
