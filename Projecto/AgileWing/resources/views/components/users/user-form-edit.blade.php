<div class="container">
    <h3>TESTE do Utilizador</h3>
    <div class="row">
        <div class="col-md-4">
            <form method="POST" action="{{ url('users/' . $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text"
                        id="id"
                        name="id"
                        autocomplete="id"
                        placeholder="{{ $user->id }}"
                        class="form-control @error('id') is-invalid @enderror"
                        value="{{ old('id') }}"
                        required aria-describedby="idHelp" readonly>
                    @error('id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text"
                        id="name"
                        name="name"
                        autocomplete="name"
                        placeholder="{{ $user->name }}"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required aria-describedby="nameHelp">
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
                        placeholder="{{ $user->email }}"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required aria-describedby="emailHelp">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color_1">Cor 1</label>
                    <div style="width: 30px; height: 30px; background-color: {{ $user->color_1 }};"></div>
                </div>

                <div class="form-group">
                    <label for="color_2">Cor 2</label>
                    <div style="width: 30px; height: 30px; background-color: {{ $user->color_2 }};"></div>
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
                            @endif>
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
                            value="{{ $specializationArea->number }}" 
                            id="specializationArea_{{ $specializationArea->number }}"
                            @if($specializationAreaUserList[$specializationArea->number]['isAssociated'])
                                checked
                            @endif>
                        <label class="form-check-label" 
                            for="specializationArea_{{ $specializationArea->number }}">
                            {{ $specializationArea->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

<div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <a href="/users" class="mt-2 mb-5 btn btn-primary">Voltar</a>
            <button type="submit" class="mt-2 mb-5 btn btn-primary">Guardar</button>
            </form>
        </div>
</div>