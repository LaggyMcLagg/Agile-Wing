@extends('master.main')

@section('content')

@component('components.content_table.content_table', ['columns' => $columns, 'rows' => $rows])
@endcomponent

@endsection