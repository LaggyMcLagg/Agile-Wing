@section('scripts')

@endsection

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

</style>
@endsection

<h3>Disponibilidades PROF SCHEDULER</h3>

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
            <h3>{{ Auth::user()->name }}</h3>

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
            <form action="{{ route('users.update-notes') }}" method="POST">
                @csrf
                <textarea name="notes">{{ old('notes', Auth::user()->notes) }}</textarea>
                @error('notes')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button class="btn btn-light" type="submit">Guardar</button>
            </form>
        </div>

        <!-- Second Column -->
        <div class="col-md-9">
            <!-- Availability Types Legend -->
            <div class="legend d-flex align-items-center">
                @foreach($availabilityTypes as $type)
                    <div class="mr-3">
                        <span data-id="{{ $type->id }}" class="mr-2">{{ $type->name }}</span>
                        <span class="legend-color-box" style="background-color: {{ $type->color }};"></span>
                    </div>
                @endforeach
            </div>
            <!-- Scheduler -->
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
                            <td>{{ $block->hour_beginning }} - {{ $block->hour_end }}</td>
                            <!-- JS will populate the scheduler cells for each day of the month here -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        // Load initial data
        loadMonthData(currentMonth, currentYear);

        document.getElementById("prevMonth").addEventListener("click", function() {
            currentMonth--;
            if(currentMonth < 0) {
                currentMonth = 11; // December
                currentYear--;
            }
            loadMonthData(currentMonth, currentYear);
        });

        document.getElementById("nextMonth").addEventListener("click", function() {
            currentMonth++;
            if(currentMonth > 11) {
                currentMonth = 0; // January
                currentYear++;
            }
            loadMonthData(currentMonth, currentYear);
        });

        function loadMonthData(month, year) {
            //CALENDER
            //erase grid
            const daysGrid = document.getElementById("daysGrid");
            daysGrid.innerHTML = '';
            
            //add weekdays
            const dayNames = ["D", "S", "T", "Q", "Q", "S", "S"];
            dayNames.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.textContent = day;
                dayElement.classList.add('day-name');
                daysGrid.appendChild(dayElement);
            });

            //set consts for logic
            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInLastMonth = new Date(year, month, 0).getDate();
            const daysInThisMonth = new Date(year, month + 1, 0).getDate();

            // Fill in the days from the previous month
            for (let i = 0; i < firstDayOfMonth; i++) {
                const dayElement = document.createElement('div');
                dayElement.textContent = daysInLastMonth - firstDayOfMonth + i + 1; // Get the correct date for the last month
                dayElement.style.color = "gray";
                daysGrid.appendChild(dayElement);
            }

            // Fill in the days for the current month
            for (let i = 1; i <= daysInThisMonth; i++) {
                const dayElement = document.createElement('div');
                dayElement.textContent = i;
                daysGrid.appendChild(dayElement);
            }

            // Fill in the days from the next month to complete the grid
            let nextMonthDay = 1;
            while (daysGrid.children.length < 49) { // 7 rows of 7 days = 49 to ensure consistency in the calendar grid
                const dayElement = document.createElement('div');
                dayElement.textContent = nextMonthDay++;
                dayElement.style.color = "gray";
                daysGrid.appendChild(dayElement);
            }

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            document.getElementById("currentMonthYear").textContent = `${monthNames[month]} ${year}`;

            //SCHEDULER
            // Update the scheduler table header
            const schedulerHeader = document.querySelector("#scheduler thead tr");
            // Remove old day headers
            while (schedulerHeader.children.length > 1) { // Keep the 'Horários' column
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
                dayOfWeekElem.style.fontSize = "0.8rem";
                
                th.appendChild(dateElem);
                th.appendChild(dayOfWeekElem);
                schedulerHeader.appendChild(th);
            }

            // Update the scheduler table body
            const schedulerRows = document.querySelectorAll("#scheduler tbody tr");
            schedulerRows.forEach(row => {
                // Remove old day cells
                while (row.children.length > 1) { // Keep the 'Horários' cell
                    row.removeChild(row.lastChild);
                }

                for (let i = 1; i <= daysInThisMonth; i++) {
                    const td = document.createElement('td');
                    row.appendChild(td);
                }
            });
        }

    });

</script>