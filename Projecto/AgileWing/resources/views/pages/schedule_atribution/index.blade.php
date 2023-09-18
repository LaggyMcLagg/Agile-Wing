@extends('master.main')
@section('content')
@component('components.schedule-atribution.schedule-atribution-form-list',compact('scheduleAtributions'))
@endcomponent
@endsection
