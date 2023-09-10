@extends('master.main')

@section('content')

@component('components.user-types.user-type-list', ['user-types' => $userTypes])
@endcomponent

@endsection 