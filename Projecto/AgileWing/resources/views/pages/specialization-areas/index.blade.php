@extends('master.main')
@section('content')
@component(
    'components.specialization-areas.specialization-areas-form-list',
    compact('specializationAreas')
    )
@endcomponent
@endsection