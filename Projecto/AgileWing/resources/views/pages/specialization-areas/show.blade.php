@extends('master.main')
@section('content')
@component('components.specialization-areas.specialization-areas-form-show', ['specializationArea' => $specializationArea])
@endcomponent
@endsection