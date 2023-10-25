@extends('master.main')

@section('content')

@component(
    'components.scheduler_component.schedulerFORDEBUG', 
    compact(
        'userNotes', 
        'availabilityTypes',
        'hourBlocks', 
        'teacherAvailabilities', 

        'showNotes',
        'showLegend',
        'showBtnStore',
        'objectName', 
        'jsonTeacherAvailabilities'
        )
    )
@endcomponent

@endsection