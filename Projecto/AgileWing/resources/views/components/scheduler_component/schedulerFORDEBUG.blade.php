@section('styles')
<style>
    .legend-color-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #333;
    }

    .month-year-nav {
        display: flex; 
        align-items: center; 
        width: 250px; 
    }  

    #currentMonthYear {
        flex-grow: 1; 
        text-align: center; 
    }

    .days-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .day-name {
        font-weight: bold; 
    }
    
    .scheduler-container {
        width: 100%;
        overflow-x: auto;
    }

</style>
@endsection

@section('scripts')
<script>
    //loads the teacher availabilities into session storage
    sessionStorage.setItem('localJson', @json($jsonTeacherAvailabilities));
    //creates a js global var with the routes
    sessionStorage.setItem('createRouteCreate', "{{ route('teacher-availabilities.create') }}");
    sessionStorage.setItem('createRouteIndex', "{{ route('teacher-availabilities.index') }}");
</script>
@endsection

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="container mt-4">
    <div class="row">
        <!-- First Column -->
        <div class="col-md-3">
            <h3>{{ $objectName }}</h3>

            <!-- Calendar Component -->
            <div class="calendar-component">
                <div class="month-year-nav">
                    <button id="prevMonth" class="btn btn-secondary">←</button>
                    <span id="currentMonthYear"></span>
                    <button id="nextMonth" class="btn btn-secondary">→</button>
                </div>
                <div id="daysGrid" class="days-grid">
                    <!-- JS will populate this -->
                </div>
            </div>

            <!-- User Notes Form -->
            @if ($showNotes)
                <form action="{{ route('users.update-notes') }}" method="POST">
                    @csrf
                    <textarea name="notes" {{ $editNotes ? '' : 'disabled' }}>{{ old('notes', Auth::user()->notes) }}</textarea>
                    @error('notes')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @if ($editNotes)
                        <button class="btn btn-light" type="submit">Guardar</button>
                    @endif
                </form>
            @endif
        </div>

        <!-- Second Column -->
        <div class="col-md-9">

            <!-- Availability Types Legend -->
            @if ($showLegend)
                <div class="legend d-flex align-items-center">
                    @foreach($availabilityTypes as $type)
                        <div class="mr-3">
                            <span class="mr-2">{{ $type->name }}</span>
                            <span data-id="{{ $type->id }}" class="legend-color-box" style="background-color: {{ $type->color }};"></span>
                        </div>
                    @endforeach
                </div>
            @endif
            <!-- Scheduler -->
            <div class="scheduler-container">
                <table id="scheduler" class="table table-bordered">
                    <!-- JS will populate this based on Hour Blocks and Availabilities -->
                    <thead>
                        <tr>
                            <th class="hour-block-header">Horários</th>
                            <!-- JS will populate the table headers for each day of the month here -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hourBlocks as $block)
                            <tr>
                                <td data-id="{{ $block->id }}">{{ $block->hour_beginning }}-{{ $block->hour_end }}</td>
                                <!-- JS will populate the scheduler cells for each day of the month here -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    buildScheduler(currentMonth, currentYear);

    document.getElementById("prevMonth").addEventListener("click", function() {
        currentMonth--;
        if(currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        buildScheduler(currentMonth, currentYear);
    });

    document.getElementById("nextMonth").addEventListener("click", function() {
        currentMonth++;
        if(currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        buildScheduler(currentMonth, currentYear);
    });

    function buildScheduler(month, year) {
        const daysGrid = document.getElementById("daysGrid");
        daysGrid.innerHTML = '';
        
        const dayNames = ["D", "S", "T", "Q", "Q", "S", "S"];
        dayNames.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.textContent = day;
            dayElement.classList.add('day-name');
            daysGrid.appendChild(dayElement);
        });

        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInLastMonth = new Date(year, month, 0).getDate();
        const daysInThisMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDayOfMonth; i++) {
            const dayElement = document.createElement('div');
            dayElement.textContent = daysInLastMonth - firstDayOfMonth + i + 1;
            dayElement.style.color = "gray";
            daysGrid.appendChild(dayElement);
        }

        for (let i = 1; i <= daysInThisMonth; i++) {
            const dayElement = document.createElement('div');
            dayElement.textContent = i;
            daysGrid.appendChild(dayElement);
        }

        let nextMonthDay = 1;
        while (daysGrid.children.length < 49) {
            const dayElement = document.createElement('div');
            dayElement.textContent = nextMonthDay++;
            dayElement.style.color = "gray";
            daysGrid.appendChild(dayElement);
        }

        const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        const monthYearEle = document.getElementById("currentMonthYear")
        monthYearEle.textContent = `${monthNames[month]} ${year}`;

        const schedulerHeader = document.querySelector("#scheduler thead tr");
        
        while (schedulerHeader.children.length > 1) {
            schedulerHeader.removeChild(schedulerHeader.lastChild);
        }

        const dayNamesShort = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"];

        for (let i = 1; i <= daysInThisMonth; i++) {
            const th = document.createElement('th');
            const dateElem = document.createElement('div');
            const dayOfWeekElem = document.createElement('div');
            
            const currentDayOfWeek = new Date(year, month, i).getDay();
            
            dateElem.textContent = i;
            dayOfWeekElem.textContent = dayNamesShort[currentDayOfWeek];
            
            th.appendChild(dateElem);
            th.appendChild(dayOfWeekElem);
            schedulerHeader.appendChild(th);
        }

        const schedulerRows = document.querySelectorAll("#scheduler tbody tr");
        schedulerRows.forEach(row => {
            while (row.children.length > 1) {
                row.removeChild(row.lastChild);
            }

            for (let i = 1; i <= daysInThisMonth; i++) {
                const td = document.createElement('td');
                const currentDate = new Date(year, month, i);
                td.setAttribute("data-date", `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`);

                td.classList.add("cells");
                row.appendChild(td);
            }
        });
    }
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    updateScheduller();

    document.getElementById("prevMonth").addEventListener("click", function() {
        updateScheduller();
    });

    document.getElementById("nextMonth").addEventListener("click", function() {
        updateScheduller();
    });

    function updateScheduller(){
        const availabilities = JSON.parse(sessionStorage.getItem('localJson'));
        const createRouteCreate = sessionStorage.getItem('createRouteCreate');
        const createRouteIndex = sessionStorage.getItem('createRouteIndex');

        availabilities.forEach(availability => {
            const availabilityDate = new Date(availability.availability_date).toISOString().split('T')[0];
            const row = document.querySelector(`#scheduler tbody tr td[data-id="${availability.hour_block_id}"]`).parentNode;
            const cell = [...row.children].find(td => td.getAttribute('data-date') === availabilityDate);

            if (cell) {
                const legendColorBox = document.querySelector(`.legend-color-box[data-id="${availability.availability_type_id}"]`);
                if (legendColorBox) {
                    cell.style.backgroundColor = legendColorBox.style.backgroundColor;
                    cell.addEventListener('click', function() {
                        window.location.href = `${createRouteIndex}/${availability.id}/${null}/edit`;
                    });
                    cell.style.cursor = 'pointer';
                }
            }
        });

        const cells = document.querySelectorAll("#scheduler tbody td:not(:first-child)");
        cells.forEach(cell => {
            if (!cell.style.backgroundColor) { 
                cell.addEventListener('click', function() {
                    window.location.href = createRouteCreate;
                });
                cell.style.cursor = 'pointer';
            }
        });
    }
});

</script>