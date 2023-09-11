<h3>Criação de bloco</h3>
<form method="POST" action="{{ url('availability_types') }}">
@csrf
<div class="form-group">
    <label for="name">Nome</label>
    <input
    type="text"
    id="name"
    name="name"
    autocomplete="name"
    placeholder="Nome da disponibilidade"
    class="form-control
    @error('hour_beginning') is-invalid @enderror"
    value="{{ old('name') }}"
    required
    aria-describedby="nameHelp">
@error('name')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
@enderror
</div>
    
<button type="submit" class="mt-2 mb-5 btn btn-primary">Gravar</button>
</form>