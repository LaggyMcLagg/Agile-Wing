@extends('master.main')
@section('content')
@component(
    'components.ufcds.ufcds-form-crud', compact(
        'ufcds',
        'pedagogicalGroups'
        )
    )
@endcomponent
@endsection