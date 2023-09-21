@extends('master.main')
@section('content')
@component(
    'components.courses.courses-form-show',
    compact('course')
    )
@endcomponent
@endsection