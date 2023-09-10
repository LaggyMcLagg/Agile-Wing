@if($course)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Course Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">ID:</div>
                    <div class="col-md-9">{{ $course->id }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Course Name:</div>
                    <div class="col-md-9">{{ $course->name }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Course initials:</div>
                    <div class="col-md-9">{{ $course->initials }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">SpecializationArea:</div>
                    <div class="col-md-9">{{ $course->specializationArea->name }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Classes list:</div>
                    <div class="col-md-9">
                        <ul>
                            @forelse($course->courseClasses as $courseClass)
                                <li>{{ $courseClass->name }} {{ $courseClass->number }}</li>
                            @empty
                                <li>No classes associated yet. :/</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Availability Type:</div>
                    <div class="col-md-9">
                        <ul>
                            @forelse($course->ufcds as $ufcd)
                                <li>{{ $ufcd->number }} {{ $ufcd->name }}</li>
                            @empty
                                <li>No UFCDs associated yet. :/</li>
                            @endforelse
                        </ul>
                    </div>
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
