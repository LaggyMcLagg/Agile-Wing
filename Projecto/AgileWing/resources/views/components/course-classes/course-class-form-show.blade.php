@if($courseClass)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Course Class Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">ID:</div>
                    <div class="col-md-9">{{ $courseClass->id }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Number:</div>
                    <div class="col-md-9">{{ $courseClass->number }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Course ID:</div>
                    <div class="col-md-9">{{ $courseClass->course_id }}</div>
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
