@extends('master.main')
@section('content')
@component('components.course-ufcd.course-ufcd-form-list',compact('courseUfcds'))
@endcomponent
@endsection
