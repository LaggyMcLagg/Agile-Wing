@extends('master.main')

@section('content')

@component('components.hour-blocks.hour-block-list', ['hourBlocks' => $hourBlocks])
@endcomponent

@endsection 