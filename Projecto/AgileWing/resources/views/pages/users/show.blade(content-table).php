@extends('master.main')

@section('content')

@component('components.header_show.user_header_show', [
    'user'  => $user
    ])
@endcomponent

@component('components.users.show', [
    'user'                  => $user,
    'columns'               => $columnsSpecializationArea,
    'rows'                  => $rowsSpecializationArea, 
    'useCheckbox'           => $useCheckbox,
])
@endcomponent

@component('components.users.show', [
    'user'                  => $user,
    'columns'               => $columnsPedagogicalGroup,
    'rows'                  => $rowsPedagogicalGroup, 
    'useCheckbox'           => $useCheckbox,
])
@endcomponent

@endsection
