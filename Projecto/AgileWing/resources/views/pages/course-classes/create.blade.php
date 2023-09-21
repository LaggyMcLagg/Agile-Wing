@extends('master.main')
@section('content')
@component('components.course-classes.course-class-form-create', [
    'courses' => $courses
    ])
@endcomponent
@endsection