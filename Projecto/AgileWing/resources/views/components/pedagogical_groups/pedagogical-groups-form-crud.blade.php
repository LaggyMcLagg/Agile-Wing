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

            <h3>Gestão de Grupos Pedagógicos</h3>
            <!-- FORM -->
            <form action="{{ route('pedagogical-groups.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using 
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Course ID -->
                <label for="id">Pedagogical Group ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label"></label>

                <!-- Course Name -->
                <div class="form-group">
                    <label for="name">Designação</label>
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

                <!-- Save and Cancel buttons, initially hidden -->
                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
        </div>

        <!-- TABELA LIST/SHOW -->
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Designação</th>
                        <th scope="col">Lista de professores</th>
                        <th scope="col">Lista UFCDs</th>
                        <th scope="col">
                            <a id="createBtn" class="btn btn-primary">Criar</a>
                            <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedagogicalGroups as $pedagogicalGroup)
                    <tr>
                        <td data-name="id">{{ $pedagogicalGroup->id }}</td>
                        <td data-name="name">{{ $pedagogicalGroup->name }}</td>
                        <td>
                            <button 
                                class="btn btn-light" 
                                type="button" 
                                data-toggle="collapse" 
                                data-target="#usersList_{{ $pedagogicalGroup->id }}">
                                Professores
                            </button>
                            <div id="usersList_{{ $pedagogicalGroup->id }}" class="collapse">
                                <ul>
                                    @forelse($pedagogicalGroup->users as $user)
                                        <li>{{ $user->name }}</li>
                                    @empty
                                        <li>Sem professores associados.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td><td>
                            <button 
                                class="btn btn-light" 
                                type="button" 
                                data-toggle="collapse" 
                                data-target="#ufcdList_{{ $pedagogicalGroup->id }}">
                                UFCDs
                            </button>
                            <div id="ufcdList_{{ $pedagogicalGroup->id }}" class="collapse">
                                <ul>
                                    @forelse($pedagogicalGroup->ufcds as $ufcd)
                                        <li>{{ $ufcd->number }} - {{ $ufcd->name }}</li>
                                    @empty
                                        <li>Sem ufcds associadas.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ route('pedagogical-groups.destroy', ['pedagogicalGroup' => $pedagogicalGroup]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
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