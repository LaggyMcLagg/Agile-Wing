@extends('master.main')
@section('content')
@component('components.course-ufcd.course-ufcd-form-show', ['courseUfcd' => $courseUfcd])
@endcomponent
@endsection
