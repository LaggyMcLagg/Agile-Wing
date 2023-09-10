@extends('master.main')

@section('content')

@component('components.users.user-list', [
    'users'             => $users,
    'lastUpdated'       => $lastUpdated,
    'lastLogin'         => $lastLogin
    ])
@endcomponent

@endsection 