@section('scripts')
<script src="{{ asset('/js/control-form-dynamic-crud.js') }}"></script>
@endsection

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<script>
    sessionStorage.removeItem("formState"); // Clear the state from local storage
    sessionStorage.removeItem("selectedId"); // Clear the stored course ID
</script>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Start of the Main Container -->
<div class="container spacing" id="listForm">
    <div class="row">

        <!-- LEFT COLUMN: CREATE/EDIT FORM -->
        <div class="col-md-4">
            <!-- FORM -->
            <form class="atec-form" action="{{ route('user-types.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override -->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- UserType ID -->
                <label for="id" hidden>Tipo de Utilizador ID: </label>
                <label data-name="id" id="id_label"></label>

                <!-- UserType Name -->
                <div class="form-group">
                    <label for="name">Nome de Tipo de Utilizador</label>
                    <input data-name="name" type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Save and Cancel buttons, initially hidden -->
                <div class="button-container">
                    <button id="saveBtn" type="submit" class="btn save-btn" style="display: none;">Guardar</button>
                    <button id="cancelBtn" class="btn cancel-btn" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- TABELA LIST/SHOW -->
        <div class="col-md-8">
            <table class="table table-borderless">
                <h3 class="title">Gestão de Tipos de utilizador
                    <a id="createBtn" class="btn btn-blue">Criar</a>
                    <a id="editBtn" type="button" class="btn btn-blue">Editar</a>
                </h3>

                <thead>
                    <tr>
                        <th scope="col">Nome Tipo de Utilizador</th>
                        <th scope="col">Apagar</th>
                        <!-- Add any other headers here that are similar to the Course table headers -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userTypes as $userType)
                    <tr>
                        <td data-name="id" hidden>{{ $userType->id }}</td>
                        <td data-name="name">{{ $userType->name }}</td>
                        <!-- Add any other columns here that are similar to the Course table columns -->
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ url('user-types/' . $userType->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-trash"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>