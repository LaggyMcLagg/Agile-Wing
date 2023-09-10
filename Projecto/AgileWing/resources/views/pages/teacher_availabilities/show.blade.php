@extends('master.main')
@section('content')
@component('components.teacher-availabilities.teacher-availabilities-form-show', ['teacherAvailability' => $teacherAvailability])
@endcomponent
@endsection