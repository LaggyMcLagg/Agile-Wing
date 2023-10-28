<div class="container spacing">
    <form method="POST" action="{{ route('users.passwordUpdate') }}" class="password-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="new_password">Nova password</label>
            <input
            type="password"
            id="new_password" 
            name="new_password"
            autocomplete="new-password"
            class="form-control @error('new_password') is-invalid @enderror"
            value="{{ old('new_password') }}"
            
            aria-describedby="passwordHelp">
            @error('new_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <small id="passwordHelp" class="form-text text-error">
                Insira uma nova senha com pelo menos 8 caracteres.
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
            
            aria-describedby="new_password_confirmationdHelp">
            @error('new_password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <small id="passwordHelp" class="form-text text-error">
                Confirme a nova password.
            </small>
        </div>
        <button type="submit" class="btn save-btn">Gravar</button>
    </form>
</div>