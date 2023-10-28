@extends('master.main')

@section('content')

@component('components.schedule_atributions.course-classes-list', 
    compact (
        'courseClasses'
    ))
@endcomponent

@endsection 