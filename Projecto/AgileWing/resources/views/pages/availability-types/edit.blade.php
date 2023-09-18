@extends('master.main')

@section('content')

@component('components.availability-types.availability-type-form-edit', ['availabilityType' => $availabilityType])
@endcomponent

@endsection