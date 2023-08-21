@extends('master.main')

@section('content')

@php
$useCheckbox = true;
@endphp

@component('components.users.show', [
    'user' => $user,
    'pedagogicalGroups' => $pedagogicalGroups,
    'pedagogicalGroupUser' => $pedagogicalGroupUser,
    'useCheckbox' => $useCheckbox
])
@endcomponent

@endsection
