@section('scripts')
<script src="{{ asset('/js/control-form-dynamic-crud.js') }}"></script>
@endsection

<!-- Start of Hour Blocks List Section -->
<h3>Lista de Blocos de Horário - LIST</h3>

<!-- If there's a success session message, display it within a styled alert box -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <script>
        sessionStorage.removeItem("formState");  // Clear the state from local storage
        sessionStorage.removeItem("selectedCourseId");  // Clear the stored course ID
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
        <!-- Left Column: Form section for block timings -->
        <div class="col-md-6"> 
            <!-- Unified Form for CRUD operations -->
            <form  action="{{ route('availability-types.store') }}" id="controlForm" method="POST">
                @csrf
                
                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using 
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Display Block ID label -->
                <label for="id">ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label 
                data-name="id"
                id="id_label">
                </label>
            
            <!-- Input for 'hour_beginning' -->
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
                    <!-- Error message for 'hour_beginning' -->
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input for 'hour_end' -->
                <div class="form-group">
                    <label for="color">Cor</label>
                    <input
                        data-name="color"
                        type="color"
                        id="color"
                        name="color"
                        class="form-control @error('color') is-invalid @enderror"
                        required
                        value="{{ old('color') }}"
                        readonly
                    >
                    <!-- Error message for 'hour_end' -->
                    @error('color')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Save and Cancel buttons, initially hidden -->
                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
        </div>

        <!-- Right Column: List of hour blocks -->
        <div class="col-md-6">
            <h5>Lista de Blocos</h5>
            <table class="table table-bordered">
                <!-- Table Headings -->
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
                <!-- Table Body: Looping through hour blocks and displaying them -->
                <tbody>
                    @foreach ($availabilityTypes as $availabilityType)
                    <tr>
                        <!-- The prop data-name let's js know where this info belongs in the form -->
                        <td data-name="id">{{ $availabilityType->id }}</td>
                        <td data-name="name">{{ $availabilityType->name }}</td>
                        <td data-name="color">
                            <div style="width: 20px; height: 20px; background-color: {{ $availabilityType->color }};"></div>
                        </td>
                        <td>
                            <!-- Form for DELETE operation -->
                            <form action="{{ url('availability-types/' . $availabilityType->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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