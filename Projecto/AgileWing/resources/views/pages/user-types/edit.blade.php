@extends('master.main')

@section('content')

@component('components.user-types.user-type-form-edit', ['user-type' => $userType])
@endcomponent

@endsection