<div class="container">
    <h3>Criação de utilizador</h3>
    <div class="row">
        <div class="col-md-4">
            <form method="POST" action="{{ url('users') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        autocomplete="name"
                        placeholder="Nome do utilizador"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                        aria-describedby="nameHelp">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        autocomplete="email"
                        placeholder="Email do utilizador"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        aria-describedby="emailHelp">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Password do utilizador"
                        class="form-control @error('password') is-invalid @enderror"
                        value="{{ old('password') }}"
                        required
                        aria-describedby="passwordHelp">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <small id="passwordHelp" class="form-text text-muted">
                        Insira uma password com pelo menos 4 caracteres.
                    </small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmação de Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        placeholder="Confirme a password"
                        class="form-control"
                        required>
                </div>


                <div class="form-group">
                    <label for="user_type_id">Tipo de Utilizador</label>
                    <select 
                        id="user_type_id" 
                        name="user_type_id" 
                        class="form-control @error('user_type_id') is-invalid @enderror">
                        @foreach($userTypes as $userType)
                            <option value="{{ $userType->id }}">{{ $userType->name }}</option>
                        @endforeach
                    </select>
                    @error('user_type_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color_1" >Cor 1</label>
                    <input
                        type="color"
                        id="color_1"
                        name="color_1"
                        class="form-control @error('color_1') is-invalid @enderror"
                        value="{{ old('color_1') }}"
                        aria-describedby="color1Help">
                    @error('color_1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group style="width: 30px; height: 30px;">
                    <label for="color_2">Cor 2</label>
                    <input
                        type="color"
                        id="color_2"
                        name="color_2"
                        class="form-control @error('color_2') is-invalid @enderror"
                        value="{{ old('color_2') }}"
                        aria-describedby="color2Help">
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
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="pedagogicalGroups[]" 
                                value="{{ $pedagogicalGroup->id }}" 
                                id="{{ $pedagogicalGroup->id }}">
                            <label 
                                class="form-check-label" 
                                for="{{ $pedagogicalGroup->id }}">
                                {{ $pedagogicalGroup->name }}
                            </label>
                        </div>
                    @endforeach
                    @error('pedagogicalGroups')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="col-md-4">


                <div class="form-group">
                    <label>Áreas de Formação</label>
                    @foreach($specializationAreas as $specializationArea)
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="specializationAreas[]" 
                                value="{{ $specializationArea->number }}" 
                                id="{{ $specializationArea->number }}">
                            <label 
                                class="form-check-label" 
                                for="{{ $specializationArea->number }}">
                                {{ $specializationArea->name }}
                            </label>
                        </div>
                    @endforeach
                    @error('specializationAreas')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                

            </div>
        </div>


        <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <a href="/users" class="mt-2 mb-5 btn btn-primary">Voltar</a>
            <button type="submit" class="mt-2 mb-5 btn btn-primary">Gravar</button>
        </div>
    </div>
</form>
</div>


