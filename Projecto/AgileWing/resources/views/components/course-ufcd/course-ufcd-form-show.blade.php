@if($courseUfcd)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Course UFCD Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action"><strong>ID:</strong> {{ $courseUfcd->id }}</li>
            <li class="list-group-item list-group-item-action"><strong>UFCD:</strong> {{ $courseUfcd->ufcd->name}}</li>
            <li class="list-group-item list-group-item-action"><strong>Course:</strong> {{ $courseUfcd->course->name}}</li>
        </ul>
    </div>
</div>
@else
<div class="container mt-5">
    <p class="text-danger">No data available</p>
</div>
@endif
