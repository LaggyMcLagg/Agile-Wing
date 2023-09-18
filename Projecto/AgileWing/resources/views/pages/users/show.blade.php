@extends('master.main')

@section('content')

@component('components.users.user-form-show', [
    'user'                          => $user,
    'pedagogicalGroupUserList'      => $pedagogicalGroupUserList,
    'specializationAreaUserList'    => $specializationAreaUserList,
    'pedagogicalGroups'             => $pedagogicalGroups,
    'specializationAreas'           =>$specializationAreas])
@endcomponent

@endsection