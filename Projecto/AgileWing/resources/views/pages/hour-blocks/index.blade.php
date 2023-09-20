@extends('master.main')

@section('content')

@component('components.hour-blocks.hour-block-list', [
    'hourBlock'  =>$hourBlock,
    'hourBlocks' => $hourBlocks])
@endcomponent

@endsection 