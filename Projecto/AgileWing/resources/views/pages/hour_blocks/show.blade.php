@extends('master.main')

@section('content')

@component('components.hour_blocks.hour-block-form-show', ['hourBlock' => $hourBlock,])
@endcomponent

@endsection