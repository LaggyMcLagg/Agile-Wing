@if($ufcd)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            UFCD Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">ID:</div>
                    <div class="col-md-9">{{ $ufcd->id }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Pedagogical Group ID:</div>
                    <div class="col-md-9">{{ $ufcd->pedagogicalGroup->id }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Number:</div>
                    <div class="col-md-9">{{ $ufcd->number }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Hours:</div>
                    <div class="col-md-9">{{ $ufcd->hours }}</div>
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
