@extends('master.main')
@section('content')
@component(
    'components.ufcds.ufcds-form-show',
    compact('ufcd')
    )
@endcomponent
@endsection