@extends('master.main')

@section('content')

@component('components.course_classes.course-classes-form-showForScheduleAtribution', compact ('courseClass'))
    @slot('scheduleAtributions', $scheduleAtributions->toJson())
@endcomponent

@endsection
