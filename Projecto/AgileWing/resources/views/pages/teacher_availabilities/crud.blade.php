
@extends('master.main')

@section('content')

@component(
    'components.availability_management_component.availability-management', 
    compact(
        'teacherAvailabilitiesGroupedByDate',
        'hourBlocks',
        'availabilityTypes',
        'isEditing',
        'userId'
        )
    )
@endcomponent

@endsection