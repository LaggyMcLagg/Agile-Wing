@extends('master.main')

@section('content')

@component('components.availability_types.availability-type-form-crud',
    compact (
        'availabilityTypes', 
        'defaultAvailabilityType'
        ))
@endcomponent

@endsection 