<h3>List de Formadores</h3>
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Nome do formador</th>
            <th scope="col">Área de formação</th>
            <th scope="col">Grupo pedagógico</th>
            <th scope="col">Último Login</th>
            <th scope="col">Última Gravação</th>
            <th scope="col"><a href="{{ url('users/create') }}" class="btn btn-primary">Create new</a></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>
                <ul>
                    @foreach ($user->specializationAreas as $specializationArea)
                        <li>{{ $specializationArea->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <ul>
                    @foreach ($user->pedagogicalGroups as $pedagogicalGroup)
                        <li>{{ $pedagogicalGroup->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ $user->lastLogin }}</td>
            <td>{{ $user->lastUpdated }}</td>
            <td>
                <a href="{{ url('users/' . $user->id) }}" type="button" class="btn btn-primary">Show</a>
                <a href="{{ url('users/' . $user->id . '/edit') }}" type="button" class="btn btn-primary">Edit</a>
                <form action="{{ url('users/' . $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
