<link rel="stylesheet" href="{{ asset('css/geral.css') }}">
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
<div class="container" id="listForm">
    <div class="row">
        <!-- LEFT COLUMN: CREATE/EDIT FORM -->
        <div class="col-md-4">


            <!-- FORM -->
            <form class="atec-form mt-5" action="{{ route('specialization-areas.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Course ID -->
                <label for="id" hidden>Area formação ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label" hidden></label>

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

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Designação</label>
                    <input data-name="name" type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" readonly>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
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
            <h3 class="title title-m mt-5">Gestão de Áreas de formação
                <a id="createBtn" class="btn btn-blue">Criar</a>
                <a id="editBtn" type="button" class="btn btn-blue">Editar</a>
            </h3>
            <div class="table-container">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" hidden>ID</th>
                            <th scope="col">Número</th>
                            <th scope="col">Designação</th>
                            <th scope="col">Lista Professores</th>
                            <th scope="col">Lista Crusos</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specializationAreas as $specializationArea)
                        <tr>
                            <td data-name="id" hidden>{{ $specializationArea->id }}</td>
                            <td data-name="number">{{ $specializationArea->number }}</td>
                            <td data-name="name">{{ $specializationArea->name }}</td>
                            <td>
                                <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#coursesList_{{ $specializationArea->id }}">
                                    Cursos
                                </button>
                                <div id="coursesList_{{ $specializationArea->id }}" class="collapse">
                                    <ul>
                                        @forelse($specializationArea->courses as $course)
                                        <li>{{ $course->initials }} - {{ $course->name }}</li>
                                        @empty
                                        <li>Sem cursos associados.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#usersList_{{ $specializationArea->id }}">
                                    Professores
                                </button>
                                <div id="usersList_{{ $specializationArea->id }}" class="collapse">
                                    <ul>
                                        @forelse($specializationArea->users as $user)
                                        <li>{{ $user->name }}</li>
                                        @empty
                                        <li>Sem professores associados.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('specialization-areas.destroy', ['specializationArea' => $specializationArea]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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