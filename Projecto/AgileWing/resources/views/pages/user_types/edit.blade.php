@extends('master.main')

@section('content')

@component('components.user_types.user-type-form-edit', ['userType' => $userType])
@endcomponent

@endsection