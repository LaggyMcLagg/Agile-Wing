<link rel="stylesheet" href="{{ asset('css/geral.css') }}">
@section('scripts')
<script src="{{ asset('/js/control-form-dynamic-crud.js') }}"></script>
<script src="{{ asset('/js/sort-table-function.js') }}"></script>
<script src="{{ asset('/js/search-table-function.js') }}"></script>
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
    sessionStorage.removeItem("selectedId"); // Clear the stored ID
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


            <!-- FORM -->
            <form class="atec-form mt-5" action="{{ route('hour-block-course-classes.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Course ID -->
                <label for="id" hidden>Hour Block Course Classes ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label" hidden></label>

                <!--Hour Beginning -->
                <div class="form-group">
                    <label for="hour_beginning">Hora inicio</label>
                    <input data-name="hour_beginning" type="text" id="hour_beginning" name="hour_beginning" class="form-control @error('hour_beginning') is-invalid @enderror"  value="{{ old('hour_beginning') }}" readonly>
                    @error('hour_beginning')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!--Hour End -->
                <div class="form-group">
                    <label for="hour_end">Hora fim</label>
                    <input data-name="hour_end" type="text" id="hour_end" name="hour_end" class="form-control @error('hour_end') is-invalid @enderror"  value="{{ old('hour_end') }}" readonly>
                    @error('hour_end')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Course Class -->
                <div class="form-group">
                    <label for="courseClass">Turma</label>
                    <select data-name="courseClass" data-type="comboBox" id="courseClass" name="course_class_id" class="form-control" disabled>
                        @foreach($courseClasses as $courseClass)
                        <option value="{{ $courseClass->id }}" @if(old('courseClass_id')==$courseClass->id) selected @endif
                            >
                            {{ $courseClass->name }} - {{ $courseClass->number }}
                        </option>
                        @endforeach
                    </select>
                </div>  

                <!-- Save and Cancel buttons, initially hidden -->
                <div class="d-flex justify-content-end mt-2 mb-5">
                    <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-save" style="display: none;">Guardar</button>
                    <button id="cancelBtn" class="mt-2 mb-5 btn btn-cancel" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- TABELA LIST/SHOW -->
        <div class="col-md-8">
            <h3 class="title">Gestão de Blocos Horário Turmas
            <!-- Live search input -->
            <a id="createBtn" class="btn btn-blue">Criar</a>
            <a id="editBtn" type="button" class="btn btn-blue">Editar</a>
            </h3>
            <div class="search-container-sm">
                <form class="users-search">
                    <input id="search-input" class="form-control mr-sm-2" type="search" placeholder="Pesquisar..." aria-label="Search">
                    <button class="btn btn-blue my-sm-0" type="submit">Procurar</button>
                </form>
            </div>
            <div class="table-container">

                <table id="sortable-table" class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" data-column-index="0" hidden>ID</th>
                            <th scope="col" data-column-index="1">Hora inicio</th>
                            <th scope="col" data-column-index="2">Hora fim</th>
                            <th scope="col" data-column-index="3">Nome Curso</th>
                            <th scope="col">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hourBlockCourseClasses as $hourBlockCourseClass)
                        <tr>
                            <td data-name="id" hidden>{{ $hourBlockCourseClass->id }}</td>
                            <td data-name="hour_beginning">{{ $hourBlockCourseClass->hour_beginning }}</td>
                            <td data-name="hour_end">{{ $hourBlockCourseClass->hour_end }}</td>
                            <td data-name="courseClass">
                                @if($hourBlockCourseClass->courseClass)
                                {{ $hourBlockCourseClass->courseClass->name }} - {{ $hourBlockCourseClass->courseClass->number }}
                                @else
                                Not available
                                @endif
                            </td>

                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('hour-block-course-classes.destroy', ['hourBlockCourseClass' => $hourBlockCourseClass]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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
</div>