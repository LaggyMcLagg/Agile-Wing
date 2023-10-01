@extends('master.main')
@section('content')
@component('components.specialization-areas.specialization-areas-form-edit', ['specializationArea' => $specializationArea])
@endcomponent
@endsection