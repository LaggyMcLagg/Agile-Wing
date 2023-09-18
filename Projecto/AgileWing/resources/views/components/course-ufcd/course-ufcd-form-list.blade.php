<div class="mb-3">
    <a href="{{ route('course-ufcd.create') }}" class="btn btn-primary">Create New Course UFCD</a>
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
            <th scope="col">Course</th>
            <th scope="col">UFCD</th>
        </tr>
    </thead>

    <tbody>
        @foreach($courseUfcds as $courseUfcd)
        <tr>
            <td>{{ $courseUfcd->course->name }}</td>
            <td>{{ $courseUfcd->ufcd->name }}</td>

            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('course-ufcd.show', ['courseUfcd' => $courseUfcd]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('course-ufcd.edit', ['courseUfcd' => $courseUfcd]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('course-ufcd.destroy', ['courseUfcd' => $courseUfcd]) }}" method="POST">
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
