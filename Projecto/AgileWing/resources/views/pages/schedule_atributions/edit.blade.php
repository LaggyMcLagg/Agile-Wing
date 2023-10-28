
@extends('master.main')

@section('scripts')
<script>
    //loads the users with ufcds into session storage
    sessionStorage.setItem('usersWithUfcdsJson', @json($usersWithUfcdsJson));
</script>
<script src="{{ asset('/js/form-control-schedule-atributions.js') }}" defer ></script>
<script src="{{ asset('/js/checkbox-control-schedule-atributions.js') }}" defer ></script>
@endsection

@section('content')

@component(
    'components.schedule_atributions.edit-form', 
    compact(
        'courseClass', 
        'hourBlockCourseClass', 
        'ufcds', 
        'processedUsers', 
        'date',
        'usersWithUfcdsJson',
        'scheduleAtribution'
    ))
@endcomponent

@endsection