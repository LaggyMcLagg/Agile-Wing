@extends('master.main')
@section('content')
<!-- The name in the folders must be consistent. -->
@component('components.course-classes.course-class-form-show', ['courseClass' => $courseClass])
@endcomponent
@endsection