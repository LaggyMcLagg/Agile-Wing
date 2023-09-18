@extends('master.main')

@section('content')

@component('components.hour-blocks.hour-block-form-show', [
    'hourBlock'             => $hourBlock,])
@endcomponent

@endsection