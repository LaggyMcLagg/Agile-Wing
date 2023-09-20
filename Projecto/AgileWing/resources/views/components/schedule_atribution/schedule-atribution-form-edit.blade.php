<form action="{{ route('schedule-atribution.update', $scheduleAtribution->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Date -->
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"  value="{{ $scheduleAtribution->date->format('Y-m-d') }}">
        @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Hour Start -->
    <div class="mb-3">
        <label for="hour_start" class="form-label">Hour Start</label>
        <input type="time" class="form-control @error('hour_start') is-invalid @enderror" id="hour_start" name="hour_start" value="{{ $scheduleAtribution->hour_start }}">
        @error('hour_start')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Hour End -->
    <div class="mb-3">
        <label for="hour_end" class="form-label">Hour End</label>
        <input type="time" class="form-control @error('hour_end') is-invalid @enderror" id="hour_end" name="hour_end"  value="{{ $scheduleAtribution->hour_end }}">
        @error('hour_end')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Availability Type ID -->
    <div class="mb-3">
        <label for="availability_type_id" class="form-label">Availability Type</label>
        <select class="form-control @error('availability_type_id') is-invalid @enderror" id="availability_type_id" name="availability_type_id">
            @foreach($availabilityTypes as $availabilityType)
                <option value="{{ $availabilityType->id }}" @if($availabilityType->id == $scheduleAtribution->availability_type_id) selected @endif>
                    {{ $availabilityType->name }}
                </option>
            @endforeach
        </select>
        @error('availability_type_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Course Class ID -->
    <div class="mb-3">
        <label for="course_class_id" class="form-label">Course Class</label>
        <select class="form-control @error('course_class_id') is-invalid @enderror" id="course_class_id" name="course_class_id">
            @foreach($courseClasses as $courseClass)
                <option value="{{ $courseClass->id }}" @if($courseClass->id == $scheduleAtribution->course_class_id) selected @endif>
                    {{ $courseClass->name }}
                </option>
            @endforeach
        </select>
        @error('course_class_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- UFCD ID -->
    <div class="mb-3">
        <label for="ufcd_id" class="form-label">UFCD</label>
        <select class="form-control @error('ufcd_id') is-invalid @enderror" id="ufcd_id" name="ufcd_id">
            @foreach($ufcds as $ufcd)
                <option value="{{ $ufcd->id }}" @if($ufcd->id == $scheduleAtribution->ufcd_id) selected @endif>
                    {{ $ufcd->name }}
                </option>
            @endforeach
        </select>
        @error('ufcd_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- User ID -->
    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}" @if($user->id == $scheduleAtribution->user_id) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Update</button>
</form>
