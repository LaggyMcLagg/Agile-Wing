@extends ('master.main')

@section ('content')

@component('components.user-types.user-type-form-show', ['userType' => $userType])
@endcomponent

@endsection