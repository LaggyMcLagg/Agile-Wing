@extends('master.main')
@section('content')
@component('components.schedule_atribution.schedule-atribution-form-list',compact('scheduleAtributions'))
@endcomponent
@endsection
