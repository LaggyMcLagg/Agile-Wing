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
<div class="container spacing" id="listForm">
    <div class="row">
        <!-- LEFT COLUMN: CREATE/EDIT FORM -->
        <div class="col-md-4">


            <!-- FORM -->
            <form class="atec-form" action="{{ route('course-classes.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using 
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Course ID -->
                <label for="id" hidden>Course Class ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label"></label>

                <!-- Course Name -->
                <div class="form-group">
                    <label for="name">Designação</label>
                    <input data-name="name" type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}" readonly>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Number -->
                <div class="form-group">
                    <label for="number">Número</label>
                    <input data-name="number" type="text" id="number" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number') }}" readonly>
                    @error('number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Course -->
                <div class="form-group">
                    <label for="course">Curso</label>
                    <select data-name="course" data-type="comboBox" id="course" name="course_id" class="form-control" disabled>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" @if(old('course_id')==$course->id) selected @endif
                            >
                            {{ $course->initials }} - {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
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
            <h3 class="title">Gestão de Turmas
                <a id="createBtn" class="btn btn-blue">Criar</a>
                <a id="editBtn" type="button" class="btn btn-blue">Editar</a>
            </h3>
            <div class="table-container">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Turma</th>
                            <th scope="col">Numero mec.</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Blocos horário</th>
                            <th scope="col">Apagar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseClasses as $courseClass)
                        <tr>
                            <td data-name="id" hidden>{{ $courseClass->id }}</td>
                            <td data-name="name">{{ $courseClass->name }}</td>
                            <td data-name="number">{{ $courseClass->number }}</td>
                            <td data-name="course">{{ $courseClass->course->initials }} - {{ $courseClass->course->name }}</td>
                            <td>
                                <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#hourBlocksList_{{ $courseClass->id }}">
                                    Blocos Horário
                                </button>
                                <div id="hourBlocksList_{{ $courseClass->id }}" class="collapse">
                                    <ul>
                                        @forelse($courseClass->hourBlockCourseClasses as $hourBlockCourseClasse)
                                        <li>{{ $hourBlockCourseClasse->hour_beginning }} - {{ $hourBlockCourseClasse->hour_end }}</li>
                                        @empty
                                        <li>Sem blocos atribuidos.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('course-classes.destroy', ['courseClass' => $courseClass]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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