<link rel="stylesheet" href="{{ asset('css/courses.css') }}">
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
        sessionStorage.removeItem("selectedId");  // Clear the stored ID
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
            <form action="{{ route('courses.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Course ID -->
                <label for="id">Course ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label"></label>

                <!-- Course Name -->
                <div class="form-group">
                    <label for="name">Course Name</label>
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

                <!-- Course Initials -->
                <div class="form-group">
                    <label for="initials">Course Initials</label>
                    <input
                        data-name="initials"
                        type="text"
                        id="initials"
                        name="initials"
                        class="form-control @error('initials') is-invalid @enderror"
                        value="{{ old('initials') }}"
                        readonly>
                    @error('initials')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Specialization Area -->
                <div class="form-group">
                <label for="specializationArea">Specialization Area</label>
                <select
                    data-name="specializationArea"
                    data-type="comboBox"
                    id="specializationArea"
                    name="specialization_area_number"
                    class="form-control"
                    disabled>
                    @foreach($specializationAreas as $area)
                        <option value="{{ $area->number }}"
                            @if(old('specialization_area_number') == $area->number) selected @endif
                        >
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

                <!-- UFCDs checkbox list -->
                <div class="form-group">
                 <label for="ufcdDropdown">UFCDs</label>
                    <div class="custom-dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($ufcds as $ufcd)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ufcd_{{ $ufcd->id }}">
                                <label class="custom-control-label" for="ufcd_{{ $ufcd->id }}">{{ $ufcd->name }}</label>
                            </div>
                            @endforeach
                            </div>
                    </div>
                </div>

                <!-- Save and Cancel buttons, initially hidden -->
                <div class="d-flex justify-content-end mt-2 mb-5"> <!-- div to put the buttons in line -->
                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- TABELA LIST/SHOW -->
        <div class="col-md-8">
            <h3 class="d-inline">Gestão de Cursos</h3>
                <a id="createBtn" class="btn btn-primary">Criar</a>
                <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome Curso</th>
                        <th scope="col">Sigla</th>
                        <th scope="col">Área de formação</th>
                        <th scope="col">Lista turmas</th>
                        <th scope="col">Lista UFCDs</th>
                        <th scope="col">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    <tr>
                        <td data-name="id">{{ $course->id }}</td>
                        <td data-name="name">{{ $course->name }}</td>
                        <td data-name="initials">{{ $course->initials }}</td>
                        <td data-name="specializationArea">{{ $course->specializationArea->name }}</td>
                        <td>
                            <button
                                class="btn btn-light"
                                type="button"
                                data-toggle="collapse"
                                data-target="#courseClassesList_{{ $course->id }}">
                                Turmas
                            </button>
                            <div id="courseClassesList_{{ $course->id }}" class="collapse">
                                <ul>
                                    @forelse($course->courseClasses as $courseClass)
                                        <li>{{ $courseClass->name }} {{ $courseClass->number }}</li>
                                    @empty
                                        <li>No classes associated yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td>
                        <td data-name="ufcds" data-list-id="ufcdsList_{{ $course->id }}">
                            <button
                                class="btn btn-light"
                                type="button"
                                data-toggle="collapse"
                                data-target="#ufcdsList_{{ $course->id }}">
                                UFCDs
                            </button>
                            <div id="ufcdsList_{{ $course->id }}" class="collapse">
                                <ul>
                                    @forelse($course->ufcds as $ufcd)
                                        <li value="{{ $ufcd->id }}">{{ $ufcd->number }} - {{ $ufcd->name }}</li>
                                    @empty
                                        <li value="-1">No UFCDs associated yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ route('courses.destroy', ['course' => $course]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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
