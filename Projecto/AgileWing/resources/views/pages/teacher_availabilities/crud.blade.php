
@extends('master.main')

@section('scripts')
<!-- this way the routes used in the js are allways updated and nor hardcoded -->
<script>
    sessionStorage.setItem('deleteSelectedRoute', '{{ route('teacher-availabilities.delete-selected') }}');
    sessionStorage.setItem('publishSelectedRoute', '{{ route('teacher-availabilities.publish-selected') }}');
    sessionStorage.setItem('baseUrl', '{{ route('teacher-availabilities.store') }}');
</script>
<script src="{{ asset('/js/availabilities-day-group-list.js') }}"></script>
<script src="{{ asset('/js/availabilities-form-dynamic-crud.js') }}"></script>
@endsection

@section('content')

@component(
    'components.availability_management_component.availability-management', 
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