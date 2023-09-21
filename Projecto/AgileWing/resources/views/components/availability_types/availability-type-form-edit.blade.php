<h2>Edição de Tipos de Utilizador</h2>
<form method="POST" action="{{ url('availability-types/' . $availabilityType->id) }}">
@csrf
@method('PUT')

<div class="form-group">
        <label for="id">ID</label>
        <input type="text"
        id="id"
        name="id"
        autocomplete="name"
        placeholder="{{ $availabilityType->id }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('id') }}" aria-describedby="idHelp" readonly>
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
        placeholder="{{ $availabilityType->name }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('name') }}" aria-describedby="nameHelp">
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
            value="{{ $availabilityType->color }}"
            aria-describedby="colorHelp">
        @error('color')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="updated_at">Data da última modificação</label>
        <input type="text"
        id="updated_at"
        name="updated_at"
        autocomplete="name"
        placeholder="{{ $availabilityType->updated_at }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('updated_at') }}" aria-describedby="updated_atHelp" readonly>
        @error('updated_at')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

<button type="submit" class="mt-2 mb-5 btn btn-primary">Guardar</button>
<a href="/availability-types" class="mt-2 mb-5 btn btn-primary">Voltar à listagem</a>
</form>