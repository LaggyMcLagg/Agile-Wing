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
            <th scope="col">Name</th>
            <th scope="col">Number</th>
            <th scope="col">Course ID</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($courseClasses as $courseClass)

        <tr scope="row">
            <td scope="col">{{ $courseClass->id }}</td>
            <td scope="col">{{ $courseClass->name }}</td>
            <td scope="col">{{ $courseClass->number }}</td>
            <td scope="col">{{ $courseClass->course_id}}</td>

            <td>
                <div class="pr-1">
                    <a href="{{url('course-class/' . $courseClass->id)}}" type="button" class="btn btn-success">Show</a>
                </div>
                <div class="pr-1">
                    <a href="{{url('course-class/' . $courseClass->id . '/edit')}}" type="button" class="btn btn-primary">Edit</a>
                </div>
                <form action="{{url('course-class/' . $courseClass->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>