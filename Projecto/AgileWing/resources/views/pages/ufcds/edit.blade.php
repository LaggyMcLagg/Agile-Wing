@extends('master.main')

@section('content')

@component(
    'components.ufcds.ufcds-form-edit',
    compact('pedagogicalGroups', 'ufcd')
)

@endcomponent

@endsection
