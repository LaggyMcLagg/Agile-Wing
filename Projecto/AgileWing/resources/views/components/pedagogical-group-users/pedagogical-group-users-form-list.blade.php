<div class="mb-3">
    <a href="{{ route('pedagogical-group-users.create') }}" class="btn btn-primary">Create New Availability</a>
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
            <th scope="col">User</th>
            <th scope="col">Pedagogical Group</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($pedagogicalGroupUsers as $pedagogicalGroupUser)
        <tr>
            <th scope="row">{{ $pedagogicalGroupUser->id }}</th>
            <td>{{ $pedagogicalGroupUser->user->name }}</td>
            <td>{{ $pedagogicalGroupUser->pedagogicalgroup->name }}</td>
            <td>
            <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('pedagogical-group-users.show', ['pedagogicalGroupUser' => $pedagogicalGroupUser]) }}" type="button" class="btn btn-success">Show</a>
                    <a href="{{ route('pedagogical-group-users.edit', ['pedagogicalGroupUser' => $pedagogicalGroupUser]) }}" type="button" class="btn btn-primary">Edit</a>
                    <form action="{{ route('pedagogical-group-users.destroy', ['pedagogicalGroupUser' => $pedagogicalGroupUser]) }}" method="POST">
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