<div class="container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Mês</th>
                <th>Horário</th>
                @foreach ($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($months as $month)
                <tr>
                    <td rowspan="3">{{ $month }}</td>
                    @foreach ($dates as $date)
                        <td>{{ $date }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>hour-block x</td>
                    @foreach ($ufcds as $ufcd)
                        <td>{{ $ufcd->number }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>hour-block y</td>
                    @foreach ($ufcds as $ufcd)
                        <td></td>
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    @foreach ($days as $day)
                        <td></td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>








<style>
    .custom-table 
    {
        border: 1px solid #ccc;
        width: 100%;
    }
    .custom-table th, .custom-table td 
    {
        padding: 10px;
        text-align: center;
    }
    .custom-table th 
    {
        background-color: #333;
        color: #fff;
    }
    .custom-table td 
    {
        border: 1px solid #ccc;
    }
</style>