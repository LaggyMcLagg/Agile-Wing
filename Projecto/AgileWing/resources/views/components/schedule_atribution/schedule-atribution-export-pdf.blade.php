Nome da turma: {{ $courseClass->name }}
<br>
Curso: {{ $courseClass->course->name }}
 ({{ $courseInitials }})
<br>
<br>

@foreach ($groupedAtributions->reverse() as $month => $atributions)
    <table class="custom-table">
        <thead>
            <tr>
                <th>{{ $month }}</th>
                @foreach($atributions->unique('formattedDate') as $uniqueAtribution)
                    <th>{{ $uniqueAtribution->formattedDate }}</th>
                @endforeach
            </tr>
            <tr>
                <th>Horário</th>
                @foreach($atributions->unique('formattedDate') as $uniqueAtribution)
                    <th>{{ $uniqueAtribution->formattedDate }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($courseClass->hourBlockCourseClasses as $hourBlockCourseClass)
                <tr>
                    <td>{{ $hourBlockCourseClass->hour_beginning }} - {{ $hourBlockCourseClass->hour_end }}</td>
                    @foreach($atributions->unique('formattedDate') as $uniqueAtribution)
                        <td>
                            @php
                                $currentAtribution = $atributions->firstWhere('formattedDate', $uniqueAtribution->formattedDate);
                            @endphp
                            @if($currentAtribution && $currentAtribution->hour_block_course_class_id == $hourBlockCourseClass->id)
                                <ul>
                                    <li>{{ $currentAtribution->ufcd->number }}</li>
                                    <li>{{ $currentAtribution->user->name }}</li>
                                    <li>{{ $currentAtribution->date }}</li>
                                </ul>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach



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