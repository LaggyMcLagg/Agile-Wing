@extends('master.main')

@section('content')

@component(
    'components.teacher_availabilities.scheduler', 
    compact(
        'availabilityTypes', 
        'teacherAvailabilities', 
        'userNotes', 
        'hourBlocks',
        'jsonData'
        )
    )
@endcomponent

@endsection