
@section('styles')
<style>
    /* <!-- SARA DPS RETIRA ISTO PARA O FICHEIRO CSS E ELIMINA ESTA SECTION STYLES--> */
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
                        <textarea name="notes" {{ $editNotes ? '' : 'disabled' }}>{{ old('notes', $userNotes) }}</textarea>
                        @error('notes')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @if ($showBtnStore)
                            <button class="btn btn-light" type="submit">Guardar</button>
                        @endif
                    </form>
                @endif
                <!-- Export to pdf -->
                @if($showExportBtn)
                    <a 
                        class="btn btn-light" 
                        href="{{ $userId ? route('user-timeline-export', $userId) : route('course-class-timeline-export', $courseClassId) }}">
                    Exportar Horário
                    </a>
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
