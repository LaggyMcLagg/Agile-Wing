@extends('master.main')
@section('content')
@component(
    'components.pedagogical-group-users.pedagogical-group-users-form-edit',
    compact(
        'users',
        'pedagogicalGroups'
    ))
@endcomponent
@endsection