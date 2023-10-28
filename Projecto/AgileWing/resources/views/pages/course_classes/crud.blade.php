@extends('master.main')
@section('content')
@component('components.course_classes.course-classes-form-crud', compact(
        'courseClasses',
        'courses'
    ))
@endcomponent
@endsection