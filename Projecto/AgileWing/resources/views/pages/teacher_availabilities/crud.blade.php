@extends('master.main')

@section('content')

@component(
    'components.teacher_availabilities.crud', 
    compact(

        )
    )
@endcomponent

@endsection