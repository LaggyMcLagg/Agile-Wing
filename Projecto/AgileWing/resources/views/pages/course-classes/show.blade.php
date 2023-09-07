@extends('master.main')
@section('content')
@component('components.courses-classes.course-class-form-show', ['courseClass' => $courseClass])
@endcomponent
@endsection