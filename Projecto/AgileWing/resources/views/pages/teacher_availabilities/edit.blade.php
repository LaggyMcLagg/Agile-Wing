@extends('master.main')
@section('content')
@component('components.teacher-availabilities.teacher-availabilities-form-edit', compact(
    'teacherAvailability',
    'users',
    'hourBlocks',
    'availabilityTypes'
    ))
@endcomponent
@endsection