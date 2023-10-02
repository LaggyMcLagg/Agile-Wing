@extends('master.main')
@section('content')
@component(
    'components.pedagogical-group-users.pedagogical-group-users-form-create',
    [
        'users' => $users,
        'pedagogicalGroups' => $pedagogicalGroups,
        ])
@endcomponent
@endsection