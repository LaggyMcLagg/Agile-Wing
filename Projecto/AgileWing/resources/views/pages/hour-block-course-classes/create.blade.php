@extends('master.main')
@section('content')
@component('components.hour-block-course-classes.hour-block-course-class-form-create',
[
'courseClasses' => $courseClasses
])
@endcomponent
@endsection