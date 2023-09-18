@extends('master.main')
@section('content')
@component('components.course-ufcd.course-ufcd-form-create', compact(
    'ufcds',
    'courses',

))
@endcomponent
@endsection
