<h3>List de Tipos de Disponibilidade</h3>
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
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Cor</th>
            <th scope="col">Data de criação</th>
            <th scope="col">Data de edição</th>
            <th scope="col"><a href="{{ url('availability-types/create') }}" class="btn btn-primary">Nova disponibilidade</a></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($availabilityTypes as $availabilityType)
        <tr>
            <td>{{ $availabilityType->id }}</td>
            <td>{{ $availabilityType->name }}</td>
            <td>
                <div style="width: 20px; height: 20px; background-color: {{ $availabilityType->color }};"></div>
            </td>
            <td>{{ $availabilityType->created_at }}</td>
            <td>{{ $availabilityType->updated_at }}</td>
            <td>
                <a href="{{ url('availability-types/' . $availabilityType->id) }}" type="button" class="btn btn-primary">Detalhes</a>
                <a href="{{ url('availability-types/' . $availabilityType->id . '/edit') }}" type="button" class="btn btn-primary">Editar</a>
                <form action="{{ url('availability-types/' . $availabilityType->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Apagar registo</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
