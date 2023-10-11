@extends('master.main')

@section('content')

@component('components.user_types.user-type-form-crud', ['userTypes' => $userTypes])
@endcomponent

@endsection 