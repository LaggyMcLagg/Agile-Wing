<h3>Bicycles List </h3>
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
            <th scope="col">Tipos de Utilizador</th>
            <th scope="col">Data de criação</th>
            <th scope="col">Data da última alteração</th>
        </tr>
    </thead>
<tbody>
    @foreach ($userTypes as $userType)
    <tr>
        <td>{{ $userType->name }}</td>
        <td>{{ $userType->created_at }}</td>
        <td>{{ $userType->updated_at }}</td>
        <td>
        <a href="{{ url('user_types/' . $userType->id) }}" type="button" class="btn btn-primary">Show</a>
        <a href="{{ url('user_types/' . $userType->id . '/edit') }}" type="button" class="btn btn-
        primary">Edit</a>
        <form action="{{url('user_types/' . $userType->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="sbmit" class="btn btn-danger">Delete</button>
        </form>
        </td>
    </tr>
    @endforeach
</tbody>
</table>