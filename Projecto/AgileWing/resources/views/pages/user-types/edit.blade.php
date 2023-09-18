@extends('master.main')

@section('content')

@component('components.user-types.user-type-form-edit', ['userType' => $userType])
@endcomponent

@endsection