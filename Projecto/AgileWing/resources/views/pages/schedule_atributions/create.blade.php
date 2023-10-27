
@extends('master.main')



@section('content')

@component(
    'components.schedule_atributions.create-form', 
    compact(
        'courseClass', 
        'hourBlockCourseClass', 
        'ufcds', 
        'filteredUsers', 
        'date'
    ))
@endcomponent

@endsection