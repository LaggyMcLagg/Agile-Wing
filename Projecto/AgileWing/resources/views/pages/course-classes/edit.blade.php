@extends('master.main')
@section('content')
@component(
    'components.course-classes.course-class-form-edit',
    compact(
        'courseClass',
        'courses',
    ))
@endcomponent
@endsection