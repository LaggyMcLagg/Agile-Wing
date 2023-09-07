@extends('master.main')
@section('content')
@component('components.course-classes.course-class-form-list', ['courseClasses' => $courseClasses])
@endcomponent
@endsection