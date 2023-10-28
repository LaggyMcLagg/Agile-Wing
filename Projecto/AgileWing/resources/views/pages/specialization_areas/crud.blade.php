@extends('master.main')
@section('content')
@component(
    'components.specialization_areas.specialization-areas-form-crud',
    compact('specializationAreas')
    )
@endcomponent
@endsection