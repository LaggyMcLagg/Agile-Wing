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
        <!-- Left Column: Form section for block timings -->
        <div class="col-md-6"> 
            <!-- Unified Form for CRUD operations -->
            <form  action="{{ route('hour-blocks.store') }}" id="controlForm" method="POST">
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
                    <label for="hour_beginning">Hora de início</label>
                    <input
                        data-name="hour_beginning"
                        type="text"
                        id="hour_beginning"
                        name="hour_beginning"
                        class="form-control @error('hour_beginning') is-invalid @enderror"
                        required
                        value="{{ old('hour_beginning') }}"
                        readonly
                    >
                    <!-- Error message for 'hour_beginning' -->
                    @error('hour_beginning')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input for 'hour_end' -->
                <div class="form-group">
                    <label for="hour_end">Hora de fim</label>
                    <input
                        data-name="hour_end"
                        type="text"
                        id="hour_end"
                        name="hour_end"
                        class="form-control @error('hour_end') is-invalid @enderror"
                        required
                        value="{{ old('hour_end') }}"
                        readonly
                    >
                    <!-- Error message for 'hour_end' -->
                    @error('hour_end')
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
                        <th scope="col">Hora início</th>
                        <th scope="col">Hora de fim</th>
                        <th scope="col">
                            <!-- Create and Edit Buttons -->
                            <a id="createBtn" class="btn btn-primary">Criar</a>
                            <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
                        </th>
                    </tr>
                </thead>
                <!-- Table Body: Looping through hour blocks and displaying them -->
                <tbody>
                    @foreach ($hourBlocks as $hourBlock)
                    <tr>
                        <!-- The prop data-name let's js know where this info belongs in the form -->
                        <td data-name="id">{{ $hourBlock->id }}</td>
                        <td data-name="hour_beginning">{{ $hourBlock->hour_beginning }}</td>
                        <td data-name="hour_end">{{ $hourBlock->hour_end }}</td>
                        <td>
                            <!-- Form for DELETE operation -->
                            <form action="{{ url('hour-blocks/' . $hourBlock->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Apagar bloco</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>