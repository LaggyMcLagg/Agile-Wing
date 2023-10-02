@extends('master.main')
@section('content')
@component('components.pedagogical-groups.pedagogical-groups-form-edit', ['pedagogicalGroup' => $pedagogicalGroup])
@endcomponent
@endsection