@extends('master.main')

@section('content')

@component('components.hour_blocks.hour-block-list', [
    'hourBlocks' => $hourBlocks])
@endcomponent

@endsection 