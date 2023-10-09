@extends('master.main')

@section('content')

@component('components.course_classes.course-classes-form-listForScheduleAtribution', compact ('courseClasses'))
@endcomponent

@endsection
