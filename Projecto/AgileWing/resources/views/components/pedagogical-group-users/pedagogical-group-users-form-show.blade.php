@if($pedagogicalGroupUser)
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Pedagogical Group User Details
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">User:</div>
                    <div class="col-md-9">{{ $pedagogicalGroupUser->user->name }}</div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Pedagogical Group:</div>
                    <div class="col-md-9">{{ $pedagogicalGroupUser->pedagogicalGroup->name }}</div>
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
