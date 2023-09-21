<div class="mb-3">
    <a href="{{ route('courses.create') }}" class="btn btn-primary">Create New Availability</a>
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
            <th scope="col">Course Name</th>
            <th scope="col">Course initials</th>
            <th scope="col">Specialization Area</th>
            <th scope="col">Classes list</th>
            <th scope="col">UFCDs list</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($courses as $course)
            <tr>
                <th scope="row">{{ $course->id }}</th>
                <td>{{ $course->name }}</td>
                <td>{{ $course->initials }}</td>
                <td>{{ $course->specializationArea->name }}</td>
                <td>
                    <ul>
                        @forelse($course->courseClasses as $courseClass)
                            <li>{{ $courseClass->name }} {{ $courseClass->number }}</li>
                        @empty
                            <li>No classes associated yet. :/</li>
                        @endforelse
                    </ul>
                </td>
                <td>
                    <ul>
                        @forelse($course->ufcds as $ufcd)
                            <li>{{ $ufcd->number }} {{ $ufcd->name }}</li>
                        @empty
                            <li>No UFCDs associated yet. :/</li>
                        @endforelse
                    </ul>
                </td>
                <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('courses.show', ['course' => $course]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('courses.edit', ['course' => $course]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('courses.destroy', ['course' => $course]) }}" method="POST">
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