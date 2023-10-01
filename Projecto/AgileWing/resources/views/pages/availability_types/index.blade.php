@extends('master.main')

@section('content')

@component('components.availability_types.availability-type-list', ['availabilityTypes' => $availabilityTypes])
@endcomponent

@endsection 