@extends('master.main')

@section('scripts')
<script>
    //loads the teacher availabilities into session storage
    sessionStorage.setItem('localJson', @json($jsonTeacherAvailabilities));
    //creates a js global var with the routes
    sessionStorage.setItem('createRouteCreate', "{{ route('teacher-availabilities.create') }}");
    sessionStorage.setItem('createRouteIndex', "{{ route('teacher-availabilities.index') }}");
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
        'teacherAvailabilities', 

        'showNotes',
        'editNotes',
        'showLegend',
        'showBtnStore',
        'objectName', 
        'jsonTeacherAvailabilities'
        )
    )
@endcomponent

@endsection