<h3>Edit Product</h3>
<form method="POST" action="{{ url('users/' . $user->id) }}">
@csrf
@method('PUT')
    <div class="form-group">
        <label for="name">ID</label>
        <input type="text"
        id="id"
        name="id"
        autocomplete="id"
        placeholder="{{ $user->id }}"
        class="form-control
        @error('id') is-invalid @enderror" value="{{ old('id') }}" required aria-describedby="idHelp" readonly>
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
        @error('id') is-invalid @enderror" value="{{ old('name') }}" required aria-describedby="nameHelp">
    @error('name')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <div class="form-group">
        <label for="details">Email</label>
        <input type="text"
        id="email"
        name="email"
        autocomplete="email"
        placeholder="{{ $user->email }}"
        class="form-control
        @error('email') is-invalid @enderror" value="{{ old('email') }}" required aria-describedby="emailHelp">
    @error('email')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
<div class="form-group">
    <label for="created_at">Observações</label>
    <input type="text"
    id="notes"
    name="notes"
    autocomplete="notes"
    placeholder="{{ $user->notes }}"
    class="form-control
    @error('notes') is-invalid @enderror" value="{{ old('created_at') }}" required aria-describedby="notesHelp" readonly>
    @error('notes')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<button type="submit" class="mt-2 mb-5 btn btn-primary">Gravar</button>
<a href="/users" class="mt-2 mb-5 btn btn-primary">Voltar à Listagem</a>
</form>