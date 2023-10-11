@extends('master.main')
@section('content')
@component('components.schedule-atribution.schedule-atribution-form-show', ['scheduleAtribution' => $scheduleAtribution])
@endcomponent
@endsection
