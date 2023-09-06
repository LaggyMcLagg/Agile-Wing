@extends('master.main')

@section('content')

@component('components.users.list', [
    'columns'       => $columns, 
    'rows'          => $rows, 
    'objectIds'     => $objectIds, 
    'useCheckbox'   => $useCheckbox])
@endcomponent

@endsection