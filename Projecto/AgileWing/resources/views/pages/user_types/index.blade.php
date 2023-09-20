@extends('master.main')

@section('content')

@component('components.user_types.user-type-list', ['userTypes' => $userTypes])
@endcomponent

@endsection 