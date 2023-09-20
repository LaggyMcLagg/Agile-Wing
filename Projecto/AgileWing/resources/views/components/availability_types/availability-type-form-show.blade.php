<h3>Detalhes do Bloco</h3>
<form method="POST" action="{{ url('availabilityType') }}">
    @csrf
    <div class="form-group">
        <label for="id">Tipo de disponibilidade</label>
        <input type="text"
            id="name"
            name="name"
            autocomplete="name"
            placeholder="{{ $availabilityType->name }}"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
            required aria-describedby="nameHelp"
            readonly>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="color">Cor</label>
        <div style="width: 20px; height: 20px; background-color: {{ $availabilityType->color }};"></div>
    </div>

    <a href="/availability-types" class="mt-2 mb-5 btn btn-primary">Voltar à Listagem</a>
</form>
