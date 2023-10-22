<style>
    .custom-table 
    {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th, .custom-table td 
    {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    .custom-table th {
        background-color: #f2f2f2;
    }
</style>

Nome da turma: {{ $courseClass->name }}
<br>
Curso: {{ $courseClass->course->name }}
<br>
<br>

<table class="custom-table">
    <thead>
        <tr>
            <th>Hora</th>
            <th>Segunda</th>
            <th>Terça</th>
            <th>Quarta</th>
            <th>Quinta</th>
            <th>Sexta</th>
            <th>Sábado</th>
            <th>Domingo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courseClass->hourBlockCourseClasses as $hourBlockCourseClass)
        <tr>
            <td>
                {{ $hourBlockCourseClass->hour_beginning }} - {{ $hourBlockCourseClass->hour_end }}
            </td>
            @for ($day = 1; $day <= 7; $day++)
                <td>
                <ul>
                @foreach($formattedAtributions as $scheduleAtribution)
                    @if ($scheduleAtribution->hour_block_course_class_id == $hourBlockCourseClass->id && $scheduleAtribution->date->dayOfWeek == $day)
                        <li>{{ $scheduleAtribution->ufcd->number }}</li>
                        <li>{{ $scheduleAtribution->user->name }}</li>
                        <li>{{ $scheduleAtribution->formattedDate }}</li>
                    @endif
                @endforeach
                </ul>

                </td>
            @endfor
        </tr>
        @endforeach
    </tbody>
</table>
