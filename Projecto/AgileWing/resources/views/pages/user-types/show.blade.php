@extends ('master.main')

@section ('content')

@component('components.user-types.user-type-form-show', ['user-type' => $userType])
@endcomponent

@endsection