<h2>Criação de Tipos de Utilizador</h2>
<form method="POST" action="{{ url('players') }}">
    @csrf
    <div class="form-group">
    <label for="name">Name</label>
        <input
            type="text"
            id="name"
            name="name"
            autocomplete="name"
            placeholder="Novo tipo de utilizador"
            class="form-control
            @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
            required
            aria-describedby="nameHelp">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <button type="submit" class="mt-2 mb-5 btn btn-primary">Criar</button>
</form