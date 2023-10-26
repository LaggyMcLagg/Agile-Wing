@extends('master.main')

@section('scripts')
<script>
    //loads the teacher availabilities into session storage
    sessionStorage.setItem('localJson', @json($jsonCourseClassAtributions));
    //loads the users and ids into session storage
    sessionStorage.setItem('localJsonUser', @json($jsonUser));
    //loads the ufcds and ids into session storage
    sessionStorage.setItem('localJsonUfcd', @json($jsonUfcd));
    //creates a js global var with the routes
    sessionStorage.setItem('baseUrl', "{{ route('schedule-atribution.store') }}");
    sessionStorage.setItem('userId', null);
    sessionStorage.setItem('courseClassId', "{{ $courseClassId }}");
</script>
<script src="{{ asset('/js/build-scheduler.js') }}"></script>
<script src="{{ asset('/js/update-scheduler-availabilities.js') }}"></script>
@endsection

@section('content')

@component(
    'components.scheduler_component.scheduler', 
    compact(
        'userNotes', 
        'availabilityTypes',
        'hourBlocks', 
        
        'showExportBtn',
        'showNotes',
        'editNotes',
        'showLegend',
        'showBtnStore',
        'objectName', 
        'jsonUser',
        'jsonUfcd',
        'jsonCourseClassAtributions',
        'courseClassId'
        )
    )
@endcomponent

@endsection