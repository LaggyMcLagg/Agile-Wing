@extends('master.main')
@section('content')
@component('components.hour-block-course-classes.hour-block-course-class-form-list', ['hourBlockCourseClasses' => $hourBlockCourseClasses])
@endcomponent
@endsection