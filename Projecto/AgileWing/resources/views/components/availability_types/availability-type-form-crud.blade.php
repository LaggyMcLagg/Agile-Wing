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
<div class="container spacing" id="listForm">
    <div class="row">
        <div class="col-md-4">
            <form class="atec-form" action="{{ route('availability-types.store') }}" id="controlForm" method="POST">
                @csrf

                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <label for="id" hidden>ID: </label>
                <label data-name="id" id="id_label">
                </label>

                <!-- Input for 'name' -->
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input data-name="name" type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" readonly>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Color picker -->
                <div class="form-group">
                    <label for="color">Cor</label>
                    <input data-name="color" data-type="colorPicker" type="color" id="color" name="color" class="form-control @error('color') is-invalid @enderror"  value="{{ old('color') }}" readonly>
                    @error('color')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="button-container">
                    <button id="saveBtn" type="submit" class="btn save-btn" style="display: none;">Guardar</button>
                    <button id="cancelBtn" class="btn cancel-btn" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- Right Column: List of hour blocks -->
        <div class="col-md-8">
            <h3 class="title title-m">Tipos de disponibilidade
                <a id="createBtn" class="btn btn-blue">Criar</a>
                <a id="editBtn" type="button" class="btn btn-blue">Editar</a>
            </h3>
            <div class="table-container">
                <table class="table table-borderless ">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Cor</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availabilityTypes as $availabilityType)
                        <tr>
                            <td data-name="id" hidden>{{ $availabilityType->id }}</td>
                            <td data-name="name">{{ $availabilityType->name }}</td>
                            <td data-name="color" data-value="{{ $availabilityType->color }}" style="background-color: {{ $availabilityType->color }};">
                            </td>
                            <td>
                                <!-- Form for DELETE operation -->
                                <form action="{{ route('availability-types.destroy', ['availabilityType' => $availabilityType]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-trash"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>