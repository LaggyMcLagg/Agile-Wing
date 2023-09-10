@extends('master.main')
@section('content')
@component('components.teacher-availabilities.teacher-availabilities-form-create.blade', [
    'courses' => $courses
    ])
@endcomponent
@endsection