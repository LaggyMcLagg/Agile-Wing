@section('scripts')
<script src="{{ asset('/js/users-edit-table.js') }}"></script>
@endsection

<div class="container">
    <h3>Detalhes do Utilizador - é este que está a ser usado(user-form-show)</h3>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="id">ID</label>
                    <label
                        id="id"
                        name="id"
                        class="form-control">{{ $user->id }}</label>
                </div>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text"
                        id="name"
                        name="name"
                        autocomplete="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        aria-describedby="nameHelp"
                        readonly>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text"
                        id="email"
                        name="email"
                        autocomplete="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        aria-describedby="emailHelp"
                        readonly>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="color_1">Cor 1</label>
                    <input type="color"
                        id="color_1"
                        name="color_1"
                        class="form-control @error('color_1') is-invalid @enderror"
                        value="{{ old('color_1', $user->color_1) }}"
                        readonly>
                        @error('color_1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="color_2">Cor 2</label>
                    <input type="color"
                        id="color_2"
                        name="color_2"
                        class="form-control @error('color_2') is-invalid @enderror"
                        value="{{ old('color_2', $user->color_2) }}"
                        readonly>
                        @error('color_2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>


            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Grupos Pedagógicos</label>
                    @foreach($pedagogicalGroups as $pedagogicalGroup)
                        <div class="form-check">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="pedagogicalGroups[]" 
                                value="{{ $pedagogicalGroup->id }}" 
                                id="pedagogicalGroup_{{ $pedagogicalGroup->id }}"
                                @if($pedagogicalGroupUserList[$pedagogicalGroup->id]['isAssociated'])
                                    checked
                                @endif
                                disabled>
                            <label class="form-check-label" 
                                for="pedagogicalGroup_{{ $pedagogicalGroup->id }}">
                                {{ $pedagogicalGroup->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Áreas de Formação</label>
                    @foreach($specializationAreas as $specializationArea)
                        <div class="form-check">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="specializationAreas[]" 
                                value="{{ $specializationArea->id }}" 
                                id="specializationArea_{{ $specializationArea->id }}"
                                @if($specializationAreaUserList[$specializationArea->id]['isAssociated'])
                                    checked
                                @endif
                                disabled>
                            <label class="form-check-label" 
                                for="specializationArea_{{ $specializationArea->id }}">
                                {{ $specializationArea->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button id="saveBtn" type="submit" class="btn btn-primary" style="display: none;">Guardar</button>
        <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
    </form>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button id="editBtn" type="button" class="btn btn-primary">Editar</button>
            <form id="deleteForm" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Apagar Formador</button>
            </form>
            <a id="resetPwBtn" href="{{ route('link-to-reset-password' }}" class="btn btn-danger" style="display: none;">Repor palavra passe</a>
    </div>
</div>
