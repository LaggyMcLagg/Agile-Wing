@extends('master.main')

@section('scripts')
<script>
    //loads the teacher availabilities into session storage
    sessionStorage.setItem('localJson', @json($jsonTeacherAvailabilities));
    //loads the user colours and ids into session storage
    sessionStorage.setItem('localJsonUser', null);
    //loads the ufcds and ids into session storage
    sessionStorage.setItem('localJsonUfcd', null);
    //creates a js global var with the routes
    sessionStorage.setItem('baseUrl', "{{ route('teacher-availabilities.store') }}");
    sessionStorage.setItem('userId', "{{ $userId }}");
    sessionStorage.setItem('courseClassId', null);
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
        'jsonTeacherAvailabilities',
        'userId',
        'courseClassId'
        )
    )
@endcomponent

@endsection