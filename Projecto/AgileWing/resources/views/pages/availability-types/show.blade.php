@extends('master.main')

@section('content')

@component('components.availability-types.availability-type-form-show', ['availabilityType' => $availabilityType])
@endcomponent

@endsection 