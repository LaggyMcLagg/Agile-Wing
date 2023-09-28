@section('scripts')
<script src="{{ asset('js/course_class_table.js')}}"></script>
@endsection

<h3>Lista de UFCDs</h3>

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

                <!-- Input for 'name' -->
                <div class="form-group">
                    <label for="ufcdName">Name</label>
                    <input data-name="ufcdName" type="text" id="ufcdName" name="ufcdName" autocomplete="ufcdName" class="form-control @error('ufcdName') is-invalid @enderror" required aria-describedby="ufcdNameHelp" readonly>
                    <!-- Error message for 'name' -->
                    @error('ufcdName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pedagogical_group">Pedagogical Group</label>
                    <input data-name="pedagogical_group" type="number" id="pedagogical_group" name="pedagogical_group" autocomplete="pedagogical_group" class="form-control @error('pedagogical_group') is-invalid @enderror" required aria-describedby="pedagogical_groupHelp" readonly>
                    @error('pedagogical_group')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Input for 'number' -->
                <div class="form-group">
                    <label for="ufcdNumber">Number</label>
                    <input data-name="ufcdNumber" type="number" id="ufcdNumber" name="ufcdNumber" autocomplete="ufcdNumber" class="form-control @error('ufcdNumber') is-invalid @enderror" required aria-describedby="ufcdNumberHelp" readonly>
                    @error('ufcdNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hours">Hours</label>
                    <input data-name="hours" type="number" id="hours" name="hours" autocomplete="hours" class="form-control @error('hours') is-invalid @enderror" required aria-describedby="hoursHelp" readonly>
                    @error('hours')
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
            <table class="table table-hover table-light">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Pedagogical Group Id</th>
                        <th scope="col">Number</th>
                        <th scope="col">Hours</th>
                        <th scope="col"> <a id="createBtn" class="btn btn-primary">Criar</a>
                            <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($ufcds as $ufcd)
                    <tr scope="row">
                        <td data-name="id" scope="col">{{ $ufcd->id }}</td>
                        <td data-name="ufcdName" scope="col">{{ $ufcd->name }}</td>
                        <td data-name="pedagogical_group" scope="col">{{ $ufcd->pedagogicalGroup->id }}</td>
                        <td data-name="ufcdNumber" scope="col">{{ $ufcd->number }}</td>
                        <td data-name="hours" scope="col">{{ $ufcd->hours }}</td>

                        <td>
                            <!-- Form for DELETE operation -->
                            <form action="{{ url('ufcds/' . $ufcd->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Apagar bloco</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>