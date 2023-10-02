<form method="POST" action="{{ route('users.passwordUpdate') }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="current_password">Password atual</label>
        <input
            type="password"
            id="current_password" 
            name="current_password"
            autocomplete="current-password"
            class="form-control @error('current_password') is-invalid @enderror"
            value="{{ old('current_password') }}"
            required
            aria-describedby="passwordHelp">
        @error('current_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <small id="passwordHelp" class="form-text text-muted">
            Insira sua password atual.
        </small>
    </div>

    <div class="form-group">
        <label for="new_password">Nova password</label>
        <input
            type="password"
            id="new_password" 
            name="new_password"
            autocomplete="new-password"
            class="form-control @error('new_password') is-invalid @enderror"
            value="{{ old('new_password') }}"
            required
            aria-describedby="passwordHelp">
        @error('new_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <small id="passwordHelp" class="form-text text-muted">
            Insira uma nova senha com pelo menos 4 caracteres.
        </small>
    </div>

    <div class="form-group">
        <input
            type="password"
            id="new_password_confirmation"
            name="new_password_confirmation"
            autocomplete="new_password_confirmation"
            class="form-control @error('new_password_confirmation') is-invalid @enderror"
            value="{{ old('new_password_confirmation') }}"
            required
            aria-describedby="new_password_confirmationdHelp">
        @error('new_password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <small id="passwordHelp" class="form-text text-muted">
            Confirme a nova password.
        </small>
    </div>
    <button type="submit" class="btn btn-primary">Gravar</button>
</form>