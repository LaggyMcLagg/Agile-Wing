@extends('master.main')

@section('content')

@component('components.user-types.user-type-list', ['userTypes' => $userTypes])
@endcomponent

@endsection 