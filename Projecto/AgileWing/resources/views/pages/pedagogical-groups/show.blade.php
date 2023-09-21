@extends('master.main')
@section('content')
@component('components.pedagogical-groups.pedagogical-groups-form-show', ['pedagogicalGroup' => $pedagogicalGroup])
@endcomponent
@endsection