@extends('master.main')
@section('content')
@component(
    'components.pedagogical-group-users.pedagogical-group-users-form-list',
    compact('pedagogicalGroupUsers')
    )
@endcomponent
@endsection