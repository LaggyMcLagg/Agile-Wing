@extends('master.main')

@section('content')

@component('components.availability_types.availability-type-form-show', ['availabilityType' => $availabilityType])
@endcomponent

@endsection 