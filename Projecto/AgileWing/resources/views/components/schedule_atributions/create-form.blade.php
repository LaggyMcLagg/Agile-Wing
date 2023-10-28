@section('styles')
<style> 
.selected {
    background-color: #d1e7dd;
}
.color-box{
    display: inline-block; 
    width: 15px;
    height: 15px;
}
</style>
@endsection
<div class="container">

    <!-- Date and Hour Block Info + Form on the Left, and Tables on the Right -->
    <div class="row">

    <!-- Date, Hour Block, and Form -->
    <div class="col-md-3">
        <!-- Date and Hour Block Info -->
        <div class="mt-3">
            Date: {{ $date }}<br>
            Hour Block: {{ $hourBlockCourseClass->hour_beginning }} - {{ $hourBlockCourseClass->hour_end }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form with hidden fields -->
        <form id="form-schedule-atribution" action="{{ route('schedule-atribution.store') }}" method="post" class="mt-3">
            @csrf

            <!-- Checkbox for "Presencial" -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="availability_type_checkbox" id="checkbox" checked value="1">
                <label class="form-check-label" for="checkbox">Presencial</label>
            </div>

            <!-- Hidden Fields -->
            <input type="hidden" name="user_id" id="hidden-user-id" value="{{ old('user_id') }}">
            <input type="hidden" name="ufcd_id" id="hidden-ufcd-id" value="{{ old('ufcd_id') }}">
            <input type="hidden" name="course_class_id" value="{{ old('course_class_id', $courseClass->id) }}">
            <input type="hidden" name="availability_type_id" id="availability-type-id" value="{{ old('availability_type_id') }}">
            <input type="hidden" name="hour_block_course_class_id" value="{{ old('hour_block_course_class_id', $hourBlockCourseClass->id) }}">
            <input type="hidden" name="date" value="{{ old('date', $date) }}">

            <button type="submit" class="btn btn-primary mt-2">Gravar</button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="col-md-4">
        <table id="users-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processedUsers as $user)
                <tr data-user-id="{{ $user['id'] }}">
                    <td><strong>{{ $user['name'] }}</strong>
                    @if ($user['matchingAvailability'])
                        <div class="color-box" style="background-color: {{ $user['matchingAvailability']->availabilityType->color }}"></div>
                        <span>{{ $user['matchingAvailability']->availabilityType->name }}</span>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- UFCDs Table -->
    <div class="col-md-4">
        <table id="ufcds-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>UFCD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ufcds as $ufcd)
                <tr data-ufcd-id="{{ $ufcd->id }}">
                    <td>{{ $ufcd->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
