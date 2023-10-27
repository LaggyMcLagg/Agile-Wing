@extends('master.main')

@section('content')

@component('components.teacher_availabilities.user-list', [
    'users'             => $users,
    'lastUpdated'       => $lastUpdated,
    'lastLogin'         => $lastLogin
    ])
@endcomponent

@endsection
