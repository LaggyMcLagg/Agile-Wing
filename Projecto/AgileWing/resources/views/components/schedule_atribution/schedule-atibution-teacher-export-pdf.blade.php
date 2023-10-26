<h3>Cronograma formador</h3>
<h4>Nome do formador: {{ $teacherClass->name }}</h4>

<div class="container">
    @foreach ($teacherClass->scheduleAtributions->groupBy(function($date) {
        return \Carbon\Carbon::parse($date->date)->format('F Y');
    }) as $month => $scheduleAtributions)
        <table class="custom-table">
        <caption>{{ \Carbon\Carbon::parse($month)->format('m/Y') }}</caption>
            <thead>
                <tr>
                    <th>Data de Atribuição</th>
                    @foreach ($scheduleAtributions->unique('date') as $uniqueDate)
                        <th>{{ \Carbon\Carbon::parse($uniqueDate->date)->format('d/m/Y') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Marcação</td>
                    @foreach ($scheduleAtributions->unique('date') as $uniqueDate)
                        <td style="background-color: {{ $uniqueDate->backgroundColor ?? '#fff' }}">
                            @foreach ($scheduleAtributions->where('date', $uniqueDate->date) as $attribution)
                                    <b>{{ $attribution->ufcd->number }}</b><br>
                                    {{ $attribution->hourBlockCourseClass->hour_beginning }} - {{ $attribution->hourBlockCourseClass->hour_end }}<br>
                                    {{ $attribution->courseClass->name }} - {{ $attribution->courseClass->number }}<br>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @endforeach
</div>


<style>
    .container
    {
        width: 100%;
        max-width: 100%;

    }

    .custom-table 
    {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th, .custom-table td 
    {
        border: 1px solid #000;
        text-align: left;
        font-size: 5px;
        word-wrap: break-word;
    }

    .custom-table tr td {
    padding: 2px; /* Increase padding for better spacing */
    max-width: 100px; /* Adjust the maximum width to your preference */
}

.custom-table td ul {
    list-style: none;
    width: 100%; /* Adjust the width if needed */
    max-width: 100%; /* Adjust the maximum width to your preference */
    padding: 0px;
    display: flex;
    flex-wrap: wrap;
    font-size: 5px;
}


    .custom-table th {
        background-color: #f2f2f2;
    }
</style>