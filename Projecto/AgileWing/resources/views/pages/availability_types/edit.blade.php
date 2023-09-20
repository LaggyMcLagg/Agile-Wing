@extends('master.main')

@section('content')

@component('components.availability_types.availability-type-form-edit', ['availabilityType' => $availabilityType])
@endcomponent

@endsection