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
        sessionStorage.removeItem("formState");  // Clear the state from local storage
        sessionStorage.removeItem("selectedId");  // Clear the stored course ID
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
<div class="container" id="listForm">
    <div class="row"> 

        <!-- LEFT COLUMN: CREATE/EDIT FORM -->
        <div class="col-md-4"> 
            <h3>Gestão de Tipos de utilizador</h3>
            <!-- FORM -->
            <form action="{{ route('user-types.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override -->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- UserType ID -->
                <label for="id">Tipo de Utilizador ID: </label>
                <label data-name="id" id="id_label"></label>

                <!-- UserType Name -->
                <div class="form-group">
                    <label for="name">Nome de Tipo de Utilizador</label>
                    <input 
                        data-name="name" 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror"
                        required
                        value="{{ old('name') }}"
                        readonly>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Save and Cancel buttons, initially hidden -->
                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
        </div>

        <!-- TABELA LIST/SHOW -->
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome Tipo de Utilizador</th>
                        <!-- Add any other headers here that are similar to the Course table headers -->
                        <th scope="col">
                            <a id="createBtn" class="btn btn-primary">Criar</a>
                            <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userTypes as $userType)
                    <tr>
                        <td data-name="id">{{ $userType->id }}</td>
                        <td data-name="name">{{ $userType->name }}</td>
                        <!-- Add any other columns here that are similar to the Course table columns -->
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ url('user-types/' . $userType->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Apagar</button>
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
