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
        <div class="col-md-6"> 
            <h3>Tipos de disponibilidade</h3>
            <form  action="{{ route('availability-types.store') }}" id="controlForm" method="POST">
                @csrf
                
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">
                
                <label for="id">ID: </label>
                <label 
                data-name="id"
                id="id_label">
                </label>
            
            <!-- Input for 'name' -->
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input
                        data-name="name"
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        required
                        value="{{ old('name') }}"
                        readonly
                    >
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Color picker -->
                <div class="form-group">
                    <label for="color">Cor</label>
                    <input
                        data-name="color"
                        data-type="colorPicker"
                        type="color"
                        id="color"
                        name="color"
                        class="form-control @error('color') is-invalid @enderror"
                        required
                        value="{{ old('color') }}"
                        readonly
                    >
                    @error('color')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
        </div>

        <!-- Right Column: List of hour blocks -->
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Cor</th>
                        <th scope="col">
                            <!-- Create and Edit Buttons -->
                            <a id="createBtn" class="btn btn-primary">Criar</a>
                            <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($availabilityTypes as $availabilityType)
                    <tr>
                        <td data-name="id">{{ $availabilityType->id }}</td>
                        <td data-name="name">{{ $availabilityType->name }}</td>
                        <td data-name="color" 
                            data-value="{{ $availabilityType->color }}" 
                            style="background-color: {{ $availabilityType->color }};">
                        </td>                        
                        <td>
                            <!-- Form for DELETE operation -->
                            <form action="{{ route('availability-types.destroy', ['availabilityType' => $availabilityType]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Apagar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

