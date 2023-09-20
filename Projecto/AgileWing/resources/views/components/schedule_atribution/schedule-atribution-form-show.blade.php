@if($scheduleAtribution)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Schedule Atribution Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action"><strong>ID:</strong> {{ $scheduleAtribution->id }}</li>
            <li class="list-group-item list-group-item-action"><strong>Date:</strong> {{ $scheduleAtribution->date}}</li>
            <li class="list-group-item list-group-item-action"><strong>Hour Start:</strong> {{ $scheduleAtribution->hour_start}}</li>
            <li class="list-group-item list-group-item-action"><strong>Hour End:</strong> {{ $scheduleAtribution->hour_end }}</li>
            <li class="list-group-item list-group-item-action"><strong>Availability Type:</strong> {{ $scheduleAtribution->availabilityType->name }}</li>
            <li class="list-group-item list-group-item-action"><strong>Course Class:</strong> {{ $scheduleAtribution->courseClass->name }}</li>
            <li class="list-group-item list-group-item-action"><strong>UFCD:</strong> {{ $scheduleAtribution->ufcd->name }}</li>
            <li class="list-group-item list-group-item-action"><strong>User:</strong> {{ $scheduleAtribution->user->name }}</li>

        </ul>
    </div>
</div>
@else
<div class="container mt-5">
    <p class="text-danger">No data available</p>
</div>
@endif
