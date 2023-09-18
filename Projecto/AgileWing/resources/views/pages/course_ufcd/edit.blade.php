@extends('master.main')
@section('content')
@component('components.course-ufcd.course-ufcd-form-edit', compact(
    'courseUfcd',
    'ufcds',
    'courses',
))
@endcomponent
@endsection
