@extends('master.main')
@section('content')
@component(
    'components.pedagogical-group-users.pedagogical-group-users-form-show',
    compact('pedagogicalGroupUser')
    )
@endcomponent
@endsection