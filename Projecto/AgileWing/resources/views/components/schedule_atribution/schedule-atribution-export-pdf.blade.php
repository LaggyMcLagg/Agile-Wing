Nome da turma: {{ $courseClass->name }}
<br>
Curso: {{ $courseClass->course->name }}
 ({{ $courseInitials }})
<br>
<br>

<!-- por cada mes, vai gerar a informação -->
@foreach ($groupedAtributions as $month => $atributions)
    <table class="custom-table">
        <thead>
            <tr>
                <th>Horário</th>
                @foreach($atributions->unique('formattedDate') as $uniqueAtribution)
                    <th>{{ $uniqueAtribution->formattedDate }}</th>
                @endforeach
            </tr>
        </thead>
        <!-- iniciar a interação pelos blocos de horário -->
        <tbody> 
            @foreach($courseClass->hourBlockCourseClasses as $hourBlockCourseClass)
                <tr>
                    <td>{{ $hourBlockCourseClass->hour_beginning }} - {{ $hourBlockCourseClass->hour_end }}</td>
                    @foreach($atributions->unique('formattedDate') as $uniqueAtribution)
                        <td>
                            @php
                                // Filtrar as atribuições para a data e o bloco de horário atual
                                $filteredAtributions = $atributions->filter(function ($atribution) use ($uniqueAtribution, $hourBlockCourseClass) {
                                    return $atribution->formattedDate === $uniqueAtribution->formattedDate && $atribution->hour_block_course_class_id == $hourBlockCourseClass->id;
                                });
                            @endphp
                            @foreach($filteredAtributions as $currentAtribution)
                                <ul>
                                    <li>{{ $currentAtribution->ufcd->number }}</li>
                                    <li>{{ $currentAtribution->user->name }}</li>
                                    <li>{{ $currentAtribution->date }}</li>
                                </ul>
                            @endforeach
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