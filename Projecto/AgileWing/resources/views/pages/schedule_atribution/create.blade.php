@extends('master.main')
@section('content')
@component('components.schedule-atribution.schedule-atribution-form-create', compact(
    'availabilityTypes',
    'courseClasses',
    'ufcds',
    'users'
))
@endcomponent
@endsection
