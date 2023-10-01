@section('scripts')
<script src="{{ asset('js/course_class_table.js')}}"></script>
@endsection

<h3>Lista de Grupos Pedagógicos</h3>

@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
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
            <form id="controlForm" method="PUT">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using 
                @method('PUT') -->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Display Block ID label -->
                <label for="id">ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label">
                </label>

                <div class="form-group">
                    <label for="number">Number</label>
                    <input data-name="id" type="number" id="id" name="id" autocomplete="number" class="form-control @error('number') is-invalid @enderror" required aria-describedby="numberHelp" readonly>
                    @error('number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Input for 'name' -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input data-name="name" type="text" id="name" name="name" autocomplete="name" class="form-control @error('name') is-invalid @enderror" required aria-describedby="nameHelp" readonly>
                    <!-- Error message for 'name' -->
                    @error('name')
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

        <div class="col-md-6">
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">
                            <a id="createBtn" class="btn btn-primary">Criar</a>
                            <a id="editBtn" type="button" class="btn btn-primary">Editar</a>

                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($specializationAreas as $specializationArea)
                    <tr scope="row">
                        <th data-name="id">{{ $specializationArea->number }}</th>
                        <td data-name="name">{{ $specializationArea->name }}</td>
                        <td>
                            <!-- Form for DELETE operation -->
                            <form action="{{ url('specialization-areas/' . $specializationArea->number) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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