@extends('master.main')

@section('scripts')
<script src="{{ asset('/js/build-scheduler.js') }}"></script>
<script src="{{ asset('/js/update-scheduler-availabilities.js') }}"></script>
<script>
    sessionStorage.setItem('localJson', @json($jsonTeacherAvailabilities));
</script>
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
        'showLegend',
        'showBtnStore',
        'objectName', 
        'jsonTeacherAvailabilities'
        )
    )
@endcomponent

@endsection