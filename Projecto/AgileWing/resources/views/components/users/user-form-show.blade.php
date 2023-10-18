@section('scripts')
<script src="{{ asset('/js/users-edit-table.js') }}"></script>
@endsection

<div class="container spacing">
    <div class="row">
        <div class="col-md-4">
            <form class="atec-form" method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="id">ID</label>
                    <label id="id" name="id" class="form-control">{{ $user->id }}</label>
                </div>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" autocomplete="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" aria-describedby="nameHelp" readonly>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text" id="email" name="email" autocomplete="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" aria-describedby="emailHelp" readonly>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color_1">Cor 1</label>
                    <input type="color" id="color_1" name="color_1" class="form-control @error('color_1') is-invalid @enderror" value="{{ old('color_1', $user->color_1) }}" readonly>
                    @error('color_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color_2">Cor 2</label>
                    <input type="color" id="color_2" name="color_2" class="form-control @error('color_2') is-invalid @enderror" value="{{ old('color_2', $user->color_2) }}" readonly>
                    @error('color_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="button-container">
                    <button id="saveBtn" type="submit" class="btn save-btn" style="display: none;">Guardar</button>
                    <button id="cancelBtn" class="btn cancel-btn" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <h3 class="title">Detalhes do Utilizador</h3>
            <div class="form-group">
                <label>Grupos Pedagógicos</label>
                @foreach($pedagogicalGroups as $pedagogicalGroup)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="pedagogicalGroups[]" value="{{ $pedagogicalGroup->id }}" id="pedagogicalGroup_{{ $pedagogicalGroup->id }}" @if($pedagogicalGroupUserList[$pedagogicalGroup->id]['isAssociated'])
                    checked
                    @endif
                    disabled>
                    <label class="form-check-label" for="pedagogicalGroup_{{ $pedagogicalGroup->id }}">
                        {{ $pedagogicalGroup->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4 spacing-af">
            <div class="form-group line-break">
                <label>Áreas de Formação</label>
                @foreach($specializationAreas as $specializationArea)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specializationAreas[]" value="{{ $specializationArea->id }}" id="specializationArea_{{ $specializationArea->id }}" @if($specializationAreaUserList[$specializationArea->id]['isAssociated'])
                    checked
                    @endif
                    disabled>
                    <label class="form-check-label" for="specializationArea_{{ $specializationArea->id }}">
                        {{ $specializationArea->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</form>
<div class="delete-btn spacing">
    <form id="deleteForm" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn cancel-btn">Apagar Formador</button>
    </form>
</div>

<button id="editBtn" type="button" class="btn btn-blue edit-professor">Editar</button>
