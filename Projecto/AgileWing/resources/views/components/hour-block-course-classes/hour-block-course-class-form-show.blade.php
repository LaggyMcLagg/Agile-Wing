@if($hourBlockCourseClass)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Hour Block Course Class Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">ID:</div>
                    <div class="col-md-9">{{ $hourBlockCourseClass->course_class_id }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Beginning Date:</div>
                    <div class="col-md-9">{{ $hourBlockCourseClass->hour_beginning }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">End Date:</div>
                    <div class="col-md-9">{{ $hourBlockCourseClass->hour_end }}</div>
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
