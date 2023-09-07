@extends('master.main')
@section('content')
@component('components.course-classes.course-class-list', ['courseClasses' => $courseClasses])
@endcomponent
@endsection