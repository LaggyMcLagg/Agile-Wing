
@extends('master.main')

@section('content')

@component(
    'components.availability_management_component.availability-managementFORDEBUG', 
    compact(
        'teacherAvailability',
        'teacherAvailabilitiesGroupedByDate',
        'hourBlocks',
        'availabilityTypes',
        'isEditing',
        'userId'
        )
    )
@endcomponent

@endsection