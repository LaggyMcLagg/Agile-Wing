@extends('master.main')
@section('content')
@component(
    'components.ufcds.ufcds-form-list',
    compact('ufcds')
    )
@endcomponent
@endsection