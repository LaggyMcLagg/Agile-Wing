@extends('master.main')
@section('content')
@component('components.schedule-atribution.schedule-atribution-form-edit', compact(
    'scheduleAtribution',
    'availabilityTypes',
    'courseClasses',
    'ufcds',
    'users'
))
@endcomponent
@endsection
