<h3>Criação de Bloco</h3>
<form method="POST" action="{{ url('availability-types') }}">
    @csrf
    <div class="form-group">
        <label for="name">Nome</label>
        <input
            type="text"
            id="name"
            name="name"
            autocomplete="name"
            placeholder="Nome da disponibilidade"
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
        <label for="color">Cor</label>
        <input
            type="color"
            id="color"
            name="color"
            class="form-control @error('color') is-invalid @enderror"
            value="{{ old('color') }}"
            aria-describedby="colorHelp">
        @error('color')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button type="submit" class="mt-2 mb-5 btn btn-primary">Gravar</button>
</form>
