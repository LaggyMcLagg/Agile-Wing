@extends('master.main')

@section('content')

@component('components.availability-types.availability-type-list', ['availabilityTypes' => $availabilityTypes])
@endcomponent

@endsection 