@extends('master.main')

@section('content')

@component('components.users.user-form-create', [
    'userTypes'             => $userTypes,
    'pedagogicalGroups'     => $pedagogicalGroups,
    'specializationAreas'   => $specializationAreas,
    'defaultUserType'       => $defaultUserType])
@endcomponent

@endsection