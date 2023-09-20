<h2>Edição de Tipos de Utilizador</h2>
<form method="POST" action="{{ url('hour-blocks/' . $hourBlock->id) }}">
@csrf
@method('PUT')

<div class="form-group">
        <label for="id">ID</label>
        <input type="text"
        id="id"
        name="id"
        autocomplete="name"
        placeholder="{{ $hourBlock->id }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('id') }}" required aria-describedby="idHelp" readonly>
        @error('id')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="hour_beginning">Hora de início</label>
        <input type="text"
        id="hour_beginning"
        name="hour_beginning"
        autocomplete="hour_beginning"
        placeholder="{{ $hourBlock->hour_beginning }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('hour_beginning') }}" required aria-describedby="hour_beginningHelp">
        @error('hour_beginning')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="hour_end">Hora de fim</label>
        <input type="text"
        id="hour_end"
        name="hour_end"
        autocomplete="namhour_ende"
        placeholder="{{ $hourBlock->hour_end }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('hour_end') }}" required aria-describedby="created_atHelp">
        @error('hour_end')
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
        placeholder="{{ $hourBlock->updated_at }}"
        class="form-control
@error('name') is-invalid @enderror" value="{{ old('updated_at') }}" required aria-describedby="updated_atHelp" readonly>
        @error('updated_at')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

<button type="submit" class="mt-2 mb-5 btn btn-primary">Guardar</button>
<a href="/hour-blocks" class="mt-2 mb-5 btn btn-primary">Voltar à listagem</a>
</form>