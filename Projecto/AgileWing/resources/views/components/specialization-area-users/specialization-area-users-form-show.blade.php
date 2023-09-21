@if($teacherAvailability)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Teacher Availability Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">ID:</div>
                    <div class="col-md-9">{{ $teacherAvailability->id }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">User Name:</div>
                    <div class="col-md-9">{{ $teacherAvailability->user->name }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Availability Date:</div>
                    <div class="col-md-9">{{ $teacherAvailability->availability_date }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Hour Block Beginning:</div>
                    <div class="col-md-9">{{ $teacherAvailability->hourBlock->hour_beginning }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Hour Block End:</div>
                    <div class="col-md-9">{{ $teacherAvailability->hourBlock->hour_end }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Availability Type:</div>
                    <div class="col-md-9">{{ $teacherAvailability->availabilityType->name }}</div>
                </div>
            </li>
        </ul>
    </div>
</div>
@else
<div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        No data available
    </div>
</div>
@endif
