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
            <th scope="col">Course Class ID</th>
            <th scope="col">Hour Beginning</th>
            <th scope="col">Hour End</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($hourBlockCourseClasses as $hourBlockCourseClass)
        <tr scope="row">
            <td scope="col">{{ $hourBlockCourseClass->id }}</td>
            <td scope="col">{{ $hourBlockCourseClass->course_class_id }}</td>
            <td scope="col">{{ $hourBlockCourseClass->hour_beginning }}</td>
            <td scope="col">{{ $hourBlockCourseClass->hour_end}}</td>
            <td>
                <div class="pr-1">
                    <a href="{{url('hour-block-course-class/' . $hourBlockCourseClass->id)}}" type="button" class="btn btn-success">Show</a>
                </div>
                <div class="pr-1">
                    <a href="{{url('hour-block-course-class/' . $hourBlockCourseClass->id . '/edit')}}" type="button" class="btn btn-primary">Edit</a>
                </div>
                <form action="{{url('hour-block-course-class/' . $hourBlockCourseClass->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>