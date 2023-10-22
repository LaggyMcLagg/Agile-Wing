@php
    $days = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
@endphp

@component('components.schedule_atribution.schedule-atribution-export-pdf', [
    'ufcds'         => $ufcds,
    'hourBlocks'    => $hourBlocks,
    'users'         => $users,
    'days'          => $days,
    'months'        => $months,
    'year'          => $year,
    'dates'         => $dates,
])
@endcomponent
