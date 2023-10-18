@section('scripts')

@endsection

@section('styles')
<!-- SARA OU INES DPS METAM ISTO NO FICHEIRO CSS -->
<style>
    .legend-color-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #333;
    }

    #daysGrid {
    display: grid;
    grid-template-columns: repeat(7, 1fr); /* 7 days of the week */
    gap: 8px; /* Adjust as per your design */
    }
</style>
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
<script>
    const serverData = @json($jsonData);
</script>
<!-- @dd($jsonData) -->


<h3>Disponibilidades PROF</h3>
<div class="container mt-4">
    <div class="row">
        <!-- First Column -->
        <div class="col-md-4">
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
                <textarea name="notes">{{ Auth::user()->notes }}</textarea>
                <button type="submit">Guardar</button>
            </form>
        </div>

        <!-- Second Column -->
        <div class="col-md-8">
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
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
   let currentMonth = new Date().getMonth();
   let currentYear = new Date().getFullYear();

   function loadMonthData(month, year) {
       // 1. Clear the existing daysGrid
       const daysGrid = document.getElementById("daysGrid");
       daysGrid.innerHTML = '';

       // 2. Generate days of the week
       const dayNames = ["D", "S", "T", "Q", "Q", "S", "S"]; 
        dayNames.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.textContent = day;
            dayElement.classList.add('day-name');  // We might want to style day names differently
            daysGrid.appendChild(dayElement);
        });

       // 3. Generate days for the month
       const daysInMonth = new Date(year, month + 1, 0).getDate(); 
       for (let i = 1; i <= daysInMonth; i++) {
           const dayElement = document.createElement('div');
           dayElement.textContent = i;
           daysGrid.appendChild(dayElement);
       }

        // 4. Populate the scheduler for each day and hour block
        // Prepare the scheduler table
        const scheduler = document.getElementById('scheduler');
        scheduler.innerHTML = '';  // Clear previous rows

        // Header for the scheduler table (days of the month)
        const thead = document.createElement('thead');
        const trHeader = document.createElement('tr');
        for (let i = 1; i <= daysInMonth; i++) {
            const th = document.createElement('th');
            th.textContent = i;
            trHeader.appendChild(th);
        }
        thead.appendChild(trHeader);
        scheduler.appendChild(thead);

        // Body for the scheduler table (hour blocks and availabilities)
        const tbody = document.createElement('tbody');
        serverData.hourBlocks.forEach(hourBlock => {
            const tr = document.createElement('tr');
            for (let i = 1; i <= daysInMonth; i++) {
                const td = document.createElement('td');
                
                // Check for availability that matches day and hour block, then color the cell
                const availability = serverData.teacherAvailabilities.find(avail => 
                    new Date(avail.availability_date).getDate() === i && avail.hour_block_id === hourBlock.id);
                if (availability) {
                    // Fetch the color for the availability type and set it
                    const availabilityType = availabilityTypes.find(type => type.id === availability.availability_type_id);
                    td.style.backgroundColor = availabilityType ? availabilityType.color : 'grey';  // Default to grey if no match
                }

                tr.appendChild(td);
            }
            tbody.appendChild(tr);
        });
        scheduler.appendChild(tbody);

       
       // Update the currentMonthYear display
       const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
       document.getElementById("currentMonthYear").textContent = `${monthNames[month]} ${year}`;
   }

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
});
</script>
