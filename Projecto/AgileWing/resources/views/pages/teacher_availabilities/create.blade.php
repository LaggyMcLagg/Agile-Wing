@extends('master.main')
@section('content')
@component('components.teacher-availabilities.teacher-availabilities-form-create', compact(
    'users',
    'hourBlocks',
    'availabilityTypes'
))
@endcomponent
@endsection