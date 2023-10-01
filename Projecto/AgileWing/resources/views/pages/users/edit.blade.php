@extends('master.main')

@section('content')

@component('components.users.user-list-edit', [
    'users'             => $users,
    'lastUpdated'       => $lastUpdated,
    'lastLogin'         => $lastLogin
    ])
@endcomponent

@endsection 