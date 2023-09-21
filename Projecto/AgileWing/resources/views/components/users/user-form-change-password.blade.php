@extends('master.main')

@section('content')

<div class="form-group">
    <label for="new_password">Nova Senha</label>
    <input type="password" class="form-control" id="new_password" name="new_password" required>
</div>
<div class="form-group">
    <label for="new_password_confirmation">Confirmar Nova Senha</label>
    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
</div>
