@extends ('master.main')

@section ('content')

@component('components.user_types.user-type-form-show', ['userType' => $userType])
@endcomponent

@endsection