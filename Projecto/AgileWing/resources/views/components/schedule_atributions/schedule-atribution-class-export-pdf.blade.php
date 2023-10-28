<h3>Cronograma turma</h3>

<p>CET: {{ $courseClass->name }}</p>
<p>Turma: {{ $courseClass->course->name }}</p>
    <div class="container">
        @foreach ($tables as $table)
            <h3 class= "date">{{ $table['month'] }}</h3>
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
                            <td @if (!empty($column)) style="background-color: {{ isset($currentAtribution['color_1']) ? $currentAtribution['color_1'] : '#ffffff' }};" @endif>
                                    @foreach ($column as $currentAtribution)
                                        <ul>
                                            <li>{{ $currentAtribution['ufcd'] }}</li>
                                            <li>{{ $currentAtribution['name'] }}</li>
                                            <li>{{ $currentAtribution['date']->format('d/m/Y') }}</li>
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



<style>
    .date{
        background-color:#dfe3e5;
    }
  h3, p {
    text-align: center;
    color: #617add;
    margin-top:10px;
}

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
        text-align: center;
        font-size: 5px;
        word-wrap: break-word;

    }
    li{
        text-align:center;
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
