<h3>List de Blocos</h3>
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
            <th scope="col">Hora início</th>
            <th scope="col">Hora de fim</th>
            <th scope="col">Data de criação</th>
            <th scope="col">Data de edição</th>
            <th scope="col"><a href="{{ url('hour_blocks/create') }}" class="btn btn-primary">Criar novo bloco</a></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hourBlocks as $hourBlock)
        <tr>
            <td>{{ $hourBlock->id }}</td>
            <td>{{ $hourBlock->hour_beginning }}</td>
            <td>{{ $hourBlock->hour_end }}</td>
            <td>{{ $hourBlock->created_at }}</td>
            <td>{{ $hourBlock->updated_at }}</td>
            <td>
                <a href="{{ url('hour_blocks/' . $hourBlock->id) }}" type="button" class="btn btn-primary">Detalhes</a>
                <a href="{{ url('hour_blocks/' . $hourBlock->id . '/edit') }}" type="button" class="btn btn-primary">Editar</a>
                <form action="{{ url('hour_blocks/' . $hourBlock->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Apagar bloco</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
