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
    sessionStorage.removeItem("formState");
    sessionStorage.removeItem("selectedId");
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

<div class="container" id="listForm">
    <div class="row">
        <div class="col-md-4">


            <form class="atec-form mt-5" action="{{ route('ufcds.store') }}" id="controlForm" method="POST">
                @csrf

                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <label for="id" hidden>UFCD ID: </label>
                <label data-name="id" id="id_label" hidden></label>

                <div class="form-group">
                    <label for="number">Número</label>
                    <input
                        data-name="number"
                        type="text"
                        id="number"
                        name="number"
                        class="form-control @error('number') is-invalid @enderror"
                        value="{{ old('number') }}"
                        readonly>
                    @error('number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Designação</label>
                    <input
                        data-name="name"
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        readonly>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hours">Horas</label>
                    <input data-name="hours" type="text" id="hours" name="hours" class="form-control @error('hours') is-invalid @enderror"  value="{{ old('hours') }}" readonly>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pedagogicalGroup">Grupo Pedagógico</label>
                    <select data-name="pedagogicalGroup" data-type="comboBox" id="pedagogicalGroup" name="pedagogical_group_id" class="form-control" disabled>
                        @foreach($pedagogicalGroups as $group)
                        <option value="{{ $group->id }}" @if(old('pedagogical_group_id')==$group->id) selected @endif
                            >
                            {{ $group->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-2 mb-5">
                    <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-save" style="display: none;">Guardar</button>
                    <button id="cancelBtn" class="mt-2 mb-5 btn btn-cancel" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>

        <div class="col-md-8">
            <h3 class="title">Gestão de UFCDs
                <a id="createBtn" class="btn btn-blue">Criar</a>
                <a id="editBtn" type="button" class="btn btn-blue">Editar</a>
            </h3>
            <div class="table-container">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" hidden>ID</th>
                            <th scope="col">Numero</th>
                            <th scope="col">Designação</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Grupo Pedagógico</th>
                            <th scope="col">Lista cursos</th>
                            <th scope="col">Lista professores</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ufcds as $ufcd)
                        <tr>
                            <td data-name="id" hidden>{{ $ufcd->id }}</td>
                            <td data-name="number">{{ $ufcd->number }}</td>
                            <td data-name="name">{{ $ufcd->name }}</td>
                            <td data-name="hours">{{ $ufcd->hours }}</td>
                            <td data-name="pedagogicalGroup">{{ $ufcd->pedagogicalGroup->name }}</td>

                            <td>
                                <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#courseClassesList_{{ $ufcd->id }}">
                                    Turmas
                                </button>
                                <div id="courseClassesList_{{ $ufcd->id }}" class="collapse">
                                    <ul>
                                        @forelse($ufcd->courses as $course)
                                        <li>{{ $course->name }} {{ $course->number }}</li>
                                    @empty
                                        <li>Sem turmas associadas.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td>

                            <td>
                                <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#usersList_{{ $ufcd->id }}">
                                    Professores
                                </button>
                                <div id="usersList_{{ $ufcd->id }}" class="collapse">
                                    <ul>
                                        @forelse($ufcd->users as $user)
                                        <li>{{ $user->name }}</li>
                                    @empty
                                        <li>Sem Formadores associados.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td>

                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('ufcds.destroy', ['ufcd' => $ufcd]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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