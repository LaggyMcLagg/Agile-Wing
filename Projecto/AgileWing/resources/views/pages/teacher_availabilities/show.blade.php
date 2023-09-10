@extends('master.main')
@section('content')
@component(
    'components.teacher-availabilities.teacher-availabilities-form-show',
    compact('teacherAvailability')
    )
@endcomponent
@endsection