@extends('master.main')

@section('content')
<div class="container mt-4">
    <div class="row">
        
        <!-- Left Side - Calendar and Notes -->
        <div class="col-md-4">

            <!-- Label above calendar -->
            <div class="mt-2 display-flex">
                <label class="h2 center">{{ $displayLable }}</label>
            </div>

            <!-- Calendar Placeholder -->
            <!-- tentar ajustar tamanhos das divs de forma imperativa OU em vez de divs tabela -->
            <div id="calendar" class="border">
                <div class="text-center font-weight-bold mb-3">
                    {{ $monthName }}
                </div>

                <!-- Weekday Headers -->
                <div class="row border-bottom font-weight-bold">
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                        <div class="col">{{ $day }}</div>
                    @endforeach
                </div>

                <!-- Days -->
                <div class="row">
                    <!-- Display blank days for days of the previous month -->
                    @for($blankDay = 1; $blankDay < $dayOfWeekMonthStarts; $blankDay++)
                        <div class="col border p-2"></div>
                    @endfor

                    <!-- Display days of the month -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        <div class="col border p-2">{{ $day }}</div>

                        <!-- If Sunday, start a new row for the new week -->
                        @if(($day + $dayOfWeekMonthStarts - 1) % 7 == 0)
                            </div>
                            <div class="row">
                        @endif
                    @endfor

                    <!-- If the month doesn't end on a Sunday, fill in the remaining days with blanks -->
                    @while(($day + $dayOfWeekMonthStarts - 1) % 7 != 0)
                        <div class="col border p-2"></div>
                        @php
                            $day++;
                        @endphp
                    @endwhile
                </div>
            </div>

            <!-- Conditionally display the Notes textbox -->
            @if($displayNotes)
                <div class="mt-3">
                    <label for="notas">Notas</label>

                    @if($canEdit)
                        <!-- User can edit -->
                        <textarea id="notas" class="form-control">Insira aqui as suas notas.</textarea>
                    @else
                        <!-- User can only view. Display the DB info. -->
                        <!-- Put the notes from the DB inside $noteContent in the controllers return-->
                        <div id="notas-content" class="border p-2">
                            {{ $noteContent }}
                        </div>
                    @endif

                </div>
            @endif
        </div>

        <!-- Right Side - Hour Blocks Table -->
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hour Blocks</th>
                            @for ($day = 1; $day <= 31; $day++)
                                <th>{{$day}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hourBlocks as $block)
                            <tr>
                                <td style="white-space: nowrap;">{{ $block->hour_beginning }} - {{ $block->hour_end }}</td>
                                @for ($day = 1; $day <= 31; $day++)
                                        <td></td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
