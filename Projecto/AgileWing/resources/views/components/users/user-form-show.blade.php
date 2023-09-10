<h3>Detalhes do Utilizador</h3>
<form method="POST" action="{{ url('user') }}">
@csrf
<div class="form-group">
    <label for="id">ID</label>
        <input type="text"
        id="id"
        name="id"
        autocomplete="id"
        placeholder="{{ $user->id }}"
        class="form-control
        @error('id') is-invalid @enderror" value="{{ old('id') }}" required aria-describedby="idHelp"
        readonly>
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
        class="form-control
        @error('name') is-invalid @enderror" value="{{ old('name') }}" required aria-describedby="nameHelp"
        readonly>
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
        class="form-control
        @error('email') is-invalid @enderror" value="{{ old('email') }}" required aria-describedby="emailHelp"
        readonly>
    @error('email')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="name">Observações</label>
        <input type="text"
        id="notes"
        name="notes"
        autocomplete="notes"
        placeholder="{{ $user->notes }}"
        class="form-control
        @error('notes') is-invalid @enderror" value="{{ old('notes') }}" required aria-describedby="notesHelp"
        readonly>
    @error('notes')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<a href="/users" class="mt-2 mb-5 btn btn-primary">Voltar à Listagem</a>
</form>