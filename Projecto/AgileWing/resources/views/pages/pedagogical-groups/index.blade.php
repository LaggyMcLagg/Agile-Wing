@extends('master.main')
@section('content')
@component(
    'components.pedagogical-groups.pedagogical-groups-form-list',
    compact('pedagogicalGroups')
    )
@endcomponent
@endsection