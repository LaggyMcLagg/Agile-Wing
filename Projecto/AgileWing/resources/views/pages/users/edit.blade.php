@extends('master.main')

@section('content')

@component('components.users.user-form-edit', [
    'user' => $user,
    'pedagogicalGroupUserList' => $pedagogicalGroupUserList,
    'specializationAreaUserList' => $specializationAreaUserList,
    'pedagogicalGroups' => $pedagogicalGroups,
    'specializationAreas' => $specializationAreas])
@endcomponent

@endsection