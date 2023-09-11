<h3>Criação de bloco</h3>
<form method="POST" action="{{ url('hour_blocks') }}">
@csrf
<div class="form-group">
    <label for="name">Hora início</label>
    <input
    type="text"
    id="hour_beginning"
    name="hour_beginning"
    autocomplete="hour_beginning"
    placeholder="Ex: 12:50:00"
    class="form-control
    @error('hour_beginning') is-invalid @enderror"
    value="{{ old('hour_beginning') }}"
    required
    aria-describedby="hour_beginningHelp">
@error('hour_beginning')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
@enderror
</div>
<div class="form-group">
    <label for="name">Hora de fim</label>
    <input
    type="text"
    id="hour_end"
    name="hour_end"
    autocomplete="hour_end"
    placeholder="Ex: 12:50:00"
    class="form-control
    @error('hour_end') is-invalid @enderror"
    value="{{ old('hour_end') }}"
    required
    aria-describedby="hour_enddHelp">
@error('hour_end')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
@enderror
</div>
</div>
    
<button type="submit" class="mt-2 mb-5 btn btn-primary">Gravar</button>
</form>