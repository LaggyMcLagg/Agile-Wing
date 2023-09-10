@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User Name</th>
            <th scope="col">Availability Date</th>
            <th scope="col">Hour Block Beguining</th>
            <th scope="col">Hour Block End</th>
            <th scope="col">Availability Type</th>
        </tr>
    </thead>

    <tbody>
        @foreach($teacherAvailabilities as $teacherAvailability)

        <tr scope="row">
            <td scope="col">{{ $teacherAvailability->id }}</td>
            <td scope="col">{{ $teacherAvailability->User->name }}</td>
            <td scope="col">{{ $teacherAvailability->HourBlock->hour_beginning }}</td>
            <td scope="col">{{ $teacherAvailability->HourBlock->hour_end }}</td>
            <td scope="col">{{ $teacherAvailability->AvailabilityType->name }}</td>

            <td>
                <div class="pr-1">
                    <a href="{{ route('teacher-availabilities.show', ['teacherAvailability' => $teacherAvailability]) }}" type="button" class="btn btn-success">Show</a>
                </div>
                <div class="pr-1">
                    <a href="{{ route('teacher-availabilities.edit', ['teacherAvailability' => $teacherAvailability]) }}" type="button" class="btn btn-primary">Edit</a>
                </div>
                <form action="{{ route('teacher-availabilities.destroy', ['teacherAvailability' => $teacherAvailability]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>