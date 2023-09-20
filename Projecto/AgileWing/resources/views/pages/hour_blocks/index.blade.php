@extends('master.main')

@section('content')

@component('components.hour_blocks.hour-block-list', [
    'hourBlock'  =>$hourBlock,
    'hourBlocks' => $hourBlocks])
@endcomponent

@endsection 