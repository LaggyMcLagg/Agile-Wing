<div class="mb-3">
    <a href="{{ route('pedagogical-groups.create') }}" class="btn btn-primary">Create New</a>
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
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($pedagogicalGroups as $pedagogicalGroup)
        <tr>
            <th scope="row">{{ $pedagogicalGroup->id }}</th>
            <td>{{ $pedagogicalGroup->name }}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('pedagogical-groups.show', ['pedagogicalGroup' => $pedagogicalGroup]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('pedagogical-groups.edit', ['pedagogicalGroup' => $pedagogicalGroup]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('pedagogical-groups.destroy', ['pedagogicalGroup' => $pedagogicalGroup]) }}" method="POST">
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