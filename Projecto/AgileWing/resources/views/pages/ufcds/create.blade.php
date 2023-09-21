@extends('master.main')
@section('content')
@component(
    'components.ufcds.ufcds-form-create',
    [
        'pedagogicalGroups' => $pedagogicalGroups,
        ]
    )
@endcomponent
@endsection
