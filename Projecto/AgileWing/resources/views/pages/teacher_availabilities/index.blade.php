@extends('master.main')
@section('content')
@component('components.teacher-availabilities.teacher-availabilities-form-list',compact('teacherAvailabilities'))
@endcomponent
@endsection