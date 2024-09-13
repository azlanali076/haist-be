<x-mail::message>
# Assessment Info

<p><strong>Assessment ID:</strong> {{$assessment->id}}</p>
<p><strong>Resident Name:</strong> {{$assessment->patient->full_name}}</p>
<p><strong>Doctor Name:</strong> {{$assessment->patient->doctor->full_name}}</p>
<p><strong>Reported By Nurse:</strong> {{$assessment->nurse ? $assessment->nurse->full_name : "N/A"}}</p>
<p><strong>Possible Diagnosis</strong></p>
<ul>
    @foreach($assessment->possibleDiseases as $disease)
        <li>{{ $disease->name }}</li>
    @endforeach
</ul>


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
