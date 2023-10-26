<link rel="stylesheet" href="{{ asset('css/geral2.css') }}">

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
                    <button id="prevMonth" class="btn btn-blue">←</button>
                    <span id="currentMonthYear"></span>
                    <button id="nextMonth" class="btn btn-blue">→</button>
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
                    @if ($showBtnStore)
                        <button class="btn btn-save" type="submit">Guardar</button>
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

updateScheduller();

document.getElementById("prevMonth").addEventListener("click", function() {
    updateScheduller();
});

document.getElementById("nextMonth").addEventListener("click", function() {
    updateScheduller();
   
});

function updateScheduller(){
    // Load availabilities from sessionStorage
    const availabilities = JSON.parse(sessionStorage.getItem('localJson'));

    // Load user colors
    const userColors = JSON.parse(sessionStorage.getItem('localJsonUserColors'));

    const baseUrl = sessionStorage.getItem('baseUrl');
    const userId = sessionStorage.getItem('userId');
    const courseClassId = sessionStorage.getItem('courseClassId');


    availabilities.forEach(availability => {
        // Convert the availability date to YYYY-MM-DD format for comparison
        const dateToUse = availability.availability_date ? availability.availability_date : availability.date;
        const availabilityDate = new Date(dateToUse).toISOString().split('T')[0];
        

        // Get the correct cell based on date and hour block
        const idToUse = availability.hour_block_id ? availability.hour_block_id : availability.hour_block_course_class_id;
        const row = document.querySelector(`#scheduler tbody tr td[data-id="${idToUse}"]`).parentNode;            
        const cell = [...row.children].find(td => td.getAttribute('data-date') === availabilityDate);

        if (cell) {
            // Set background color according to availability type
            const legendColorBox = document.querySelector(`.legend-color-box[data-id="${availability.availability_type_id}"]`);
            if (legendColorBox) {
                cell.style.backgroundColor = legendColorBox.style.backgroundColor;

                // Attach event listener to cell
                cell.addEventListener('click', function() {
                    window.location.href = `${baseUrl}/${availability.id}/${userId}/edit`;
                });
                cell.style.cursor = 'pointer';
            } 
            else
            {

                // Find the user color based on availability user_id
                const userColor = userColors.find(uc => uc.id === availability.user_id);
                
                if(userColor) {
                    cell.style.backgroundColor = userColor.color_1;
                } 

                // Attach event listener to cell
                cell.addEventListener('click', function() {
                    window.location.href = `${baseUrl}/${availability.id}/${courseClassId}/edit`;
                });
                cell.style.cursor = 'pointer';
            }
        }
    });

    if (userId != null) {
        // create links for empty cells TEACHER AVAILABILITIES
        const cells = document.querySelectorAll("#scheduler tbody td:not(:first-child)");
        cells.forEach(cell => {
            if (!cell.style.backgroundColor) { // If the cell doesn't already contain a link via the bg-color
                cell.addEventListener('click', function() {
                    window.location.href = `${baseUrl}/create/${userId}`;
                });
                cell.style.cursor = 'pointer';
            }
        });
    } else {
        // create links for empty cells COURSE CLASSE ATRIBUTIONS
        const cells = document.querySelectorAll("#scheduler tbody td:not(:first-child)");
        cells.forEach(cell => {
            // If the cell doesn't already contain a link via the bg-color
            if (!cell.style.backgroundColor) {

                // Get the block ID from the first <td> of the row
                const blockId = cell.parentNode.querySelector('td[data-id]').getAttribute('data-id'); 

                // Get the date from the clicked cell
                const date = cell.getAttribute('data-date'); 

                cell.addEventListener('click', function() {
                    window.location.href = `${baseUrl}/create/${courseClassId}/${blockId}/${date}`;
                });
                cell.style.cursor = 'pointer';
            }
        });            
    }
}
});

</script>