@extends('master.main')

@section('content')

@component('components.hour-blocks.hour-block-form-edit', ['hourBlock' => $hourBlock])
@endcomponent

@endsection