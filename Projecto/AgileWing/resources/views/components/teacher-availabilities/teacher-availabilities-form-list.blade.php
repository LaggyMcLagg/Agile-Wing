<div class="mb-3">
    <a href="{{ route('teacher-availabilities.create') }}" class="btn btn-primary">Create New Availability</a>
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
            <th scope="col">User Name</th>
            <th scope="col">Availability Date</th>
            <th scope="col">Hour Block Beginning</th>
            <th scope="col">Hour Block End</th>
            <th scope="col">Availability Type</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($teacherAvailabilities as $teacherAvailability)
        <tr>
            <th scope="row">{{ $teacherAvailability->id }}</th>
            <td>{{ $teacherAvailability->user->name }}</td>
            <td>{{ $teacherAvailability->availability_date }}</td>
            <td>{{ $teacherAvailability->hourBlock->hour_beginning }}</td>
            <td>{{ $teacherAvailability->hourBlock->hour_end }}</td>
            <td>{{ $teacherAvailability->availabilityType->name }}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('teacher-availabilities.show', ['teacherAvailability' => $teacherAvailability]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('teacher-availabilities.edit', ['teacherAvailability' => $teacherAvailability]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('teacher-availabilities.destroy', ['teacherAvailability' => $teacherAvailability]) }}" method="POST">
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