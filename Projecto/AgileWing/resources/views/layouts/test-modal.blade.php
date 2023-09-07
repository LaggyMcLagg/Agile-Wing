
@extends('master.main')

@section('content')
<div class="container">
    <button type="button" class="btn btn-light-blue" data-toggle="modal" data-target="#myModal">
        Alerta
    </button>

    <x-warning modal-id="myModal" 
        title="Pretende publicar todas as suas disponibilidades em sistema?" 
        body="Esta ação irá bloquear futuras tentativas de modificação e enviar a sua disponibilidade para o Planeamento Central."
    ></x-warning>
</div>
@endsection
