<div class="mb-3">
    <a href="{{ route('ufcds.create') }}" class="btn btn-primary">Create New UFCDs</a>
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
            <th scope="col">Name</th>
            <th scope="col">Pedagogical Group Id</th>
            <th scope="col">Number</th>
            <th scope="col">Hours</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($ufcds as $ufcd)
        <tr>
            <th scope="row">{{ $ufcd->id }}</th>
            <td>{{ $ufcd->name }}</td>
            <td>{{ $ufcd->pedagogicalGroup->id }}</td>
            <td>{{ $ufcd->number }}</td>
            <td>{{ $ufcd->hours }}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('ufcds.show', ['ufcd' => $ufcd]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('ufcds.edit', ['ufcd' => $ufcd]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('ufcds.destroy', ['ufcd' => $ufcd]) }}" method="POST">
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