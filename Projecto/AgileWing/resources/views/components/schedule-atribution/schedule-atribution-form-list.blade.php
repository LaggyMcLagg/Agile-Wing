<div class="mb-3">
    <a href="{{ route('schedule-atribution.create') }}" class="btn btn-primary">Create New ScheduleAtribution</a>
</div>

@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<table class="table table-hover table-dark">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Hour Start</th>
            <th scope="col">Hour End</th>
            <th scope="col">Availability Type</th>
            <th scope="col">Course Class</th>
            <th scope="col">UFCD</th>
            <th scope="col">User</th>
        </tr>
    </thead>

    <tbody>
        @foreach($scheduleAtributions as $ScheduleAtribution)
        <tr>
            <th scope="row">{{ $sheduleAtribution->id }}</th>
            <td>{{ $sheduleAtribution->date }}</td>
            <td>{{ $sheduleAtribution->hourStart}}</td>
            <td>{{ $sheduleAtribution->hourEnd }}</td>
            <td>{{ $sheduleAtribution->availabilityType->name }}</td>
            <td>{{ $sheduleAtribution->courseClass->name }}</td>
            <td>{{ $sheduleAtribution->ufcd->name }}</td>
            <td>{{ $sheduleAtribution->user->name }}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('schedule-atribution.show', ['scheduleAtribution' => $scheduleAtribution]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('schedule-atribution.edit', ['scheduleAtribution' => $scheduleAtribution]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('schedule-atribution.destroy', ['scheduleAtribution' => $scheduleAtribution]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
