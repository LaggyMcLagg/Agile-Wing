<h2>Edição de Tipos de Utilizador</h2>
<form method="POST" action="{{ url('user-types/' . $userType->id) }}">
@csrf
@method('PUT')

<div class="form-group">
        <label for="id">ID</label>
        <input type="text"
        id="id"
        name="id"
        autocomplete="name"
        placeholder="{{ $userType->id }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('id') }}" required aria-describedby="idHelp" readonly>
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
        name="inamed"
        autocomplete="name"
        placeholder="{{ $userType->name }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('name') }}" required aria-describedby="nameHelp">
        @error('name')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="created_at">Data de criação</label>
        <input type="text"
        id="created_at"
        name="created_at"
        autocomplete="name"
        placeholder="{{ $userType->created_at }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('created_at') }}" required aria-describedby="created_atHelp" readonly>
        @error('created_at')
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
        placeholder="{{ $userType->created_at }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('updated_at') }}" required aria-describedby="updated_atHelp" readonly>
        @error('updated_at')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

<button type="submit" class="mt-2 mb-5 btn btn-primary">Guardar</button>
<a href="/bicycles" class="mt-2 mb-5 btn btn-primary">Voltar à listagem</a>
</form>