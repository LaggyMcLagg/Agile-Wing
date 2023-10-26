@extends('master.main')

@section('scripts')
<script>
    //loads the teacher availabilities into session storage
    sessionStorage.setItem('localJson', @json($jsonCourseClassAtributions));
    //loads the user colours and ids into session storage
    sessionStorage.setItem('localJsonUserColors', @json($jsonUserColors));
    //creates a js global var with the routes
    sessionStorage.setItem('baseUrl', "{{ route('schedule-atribution.store') }}");
    sessionStorage.setItem('userId', null);
    sessionStorage.setItem('courseClassId', "{{ $courseClassId }}");
</script>
<script src="{{ asset('/js/build-scheduler.js') }}"></script>
<!-- <script src="{{ asset('/js/update-scheduler-availabilities.js') }}"></script> -->
@endsection

@section('content')

@component(
    'components.scheduler_component.scheduler', 
    compact(
        'userNotes', 
        'availabilityTypes',
        'hourBlocks', 
        
        'showNotes',
        'editNotes',
        'showLegend',
        'showBtnStore',
        'objectName', 
        'jsonUserColors',
        'jsonCourseClassAtributions',
        'courseClassId'
        )
    )
@endcomponent

@endsection