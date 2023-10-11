@extends('master.main')

@section('content')

@component('components.hour_blocks.hour-block-form-crud',
    compact (
        'hourBlocks', 
        'defaultHourBlock'
        ))
@endcomponent

@endsection 