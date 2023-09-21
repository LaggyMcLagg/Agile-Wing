@extends('master.main')
@section('content')
@component('components.course-classes.course-class-form-show', ['courseClass' => $courseClass])
@endcomponent
@endsection