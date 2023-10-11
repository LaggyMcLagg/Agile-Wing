@section('scripts')
<script src="{{ asset('/js/search-table-function.js') }}"></script>
<script src="{{ asset('/js/sort-table-function.js') }}"></script>
<script src="{{ asset('/js/double-click-table-function.js') }}"></script>
@endsection

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form class="form-inline my-2 my-lg-0 justify-content-end">
                <input id="search-input" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</div>


<h3>Listagem de Formadores para Edição</h3>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<table class="table table-bordered" id="sortable-table">
    <thead>
        <tr>
            <th data-column-index="0" scope="col">Nome do formador</th>
            <th data-column-index="1" scope="col">Área de formação</th>
            <th data-column-index="2" scope="col">Grupo pedagógico</th>
            <th data-column-index="3" scope="col">Último Login</th>
            <th data-column-index="4" scope="col">Última Gravação</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr class="clickable-row" data-user-id="{{ $user->id }}">
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
                <form action="{{ url('users/' . $user->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
