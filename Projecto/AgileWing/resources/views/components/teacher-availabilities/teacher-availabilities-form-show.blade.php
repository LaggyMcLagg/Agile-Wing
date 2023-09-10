@if($teacherAvailability)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Teacher Availability Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action"><strong>ID:</strong> {{ $teacherAvailability->id }}</li>
            <li class="list-group-item list-group-item-action"><strong>User Name:</strong> {{ $teacherAvailability->user->name }}</li>
            <li class="list-group-item list-group-item-action"><strong>Availability Date:</strong> {{ $teacherAvailability->availability_date }}</li>
            <li class="list-group-item list-group-item-action"><strong>Hour Block Beginning:</strong> {{ $teacherAvailability->hourBlock->hour_beginning }}</li>
            <li class="list-group-item list-group-item-action"><strong>Hour Block End:</strong> {{ $teacherAvailability->hourBlock->hour_end }}</li>
            <li class="list-group-item list-group-item-action"><strong>Availability Type:</strong> {{ $teacherAvailability->availabilityType->name }}</li>
        </ul>
    </div>
</div>
@else
<div class="container mt-5">
    <p class="text-danger">No data available</p>
</div>
@endif
