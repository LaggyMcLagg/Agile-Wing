CET: {{ $courseClass->name }}
<br>
Turma: {{ $courseClass->course->name }}

<br>
<br>

    <div class="container">
        @foreach ($tables as $table)
            <h3>{{ $table['month'] }}</h3>
            <table class="custom-table">
                <thead>
                    <tr>
                        @foreach ($table['header'] as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($table['data'] as $row)
                        <tr>
                            <td>{{ $row['hour'] }}</td>
                            @foreach ($row['data'] as $column)
                                <td>
                                    @foreach ($column as $currentAtribution)
                                        <ul>
                                            <li>{{ $currentAtribution['ufcd'] }}</li>
                                            <li>{{ $currentAtribution['name'] }}</li>
                                            <li>{{ $currentAtribution['date'] }}</li>
                                        </ul>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>


<br>
<br>






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