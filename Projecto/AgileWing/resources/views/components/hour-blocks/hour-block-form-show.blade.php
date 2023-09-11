<h3>Detalhes do Bloco</h3>
<form method="POST" action="{{ url('hourBlock') }}">
@csrf
<div class="form-group">
    <label for="id">Hora de início</label>
        <input type="text"
        id="hour_beginning"
        name="hour_beginning"
        autocomplete="hour_beginning"
        placeholder="{{ $hourBlock->hour_beginning }}"
        class="form-control
        @error('hour_beginning') is-invalid @enderror" value="{{ old('hour_beginning') }}" required aria-describedby="hour_beginningHelp"
        readonly>
    @error('hour_beginning')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="id">Hora de fim</label>
        <input type="text"
        id="hour_end"
        name="hour_end"
        autocomplete="hour_end"
        placeholder="{{ $hourBlock->hour_end }}"
        class="form-control
        @error('hour_end') is-invalid @enderror" value="{{ old('hour_end') }}" required aria-describedby="hour_endHelp"
        readonly>
    @error('hour_end')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>



<a href="/hour_blocks" class="mt-2 mb-5 btn btn-primary">Voltar à Listagem</a>
</form>