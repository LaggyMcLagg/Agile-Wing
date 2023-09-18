<form action="{{ route('schedule-atribution.store') }}" method="POST">
    @csrf


    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date">
        @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="hour_start" class="form-label">Hour Start</label>
        <input type="time" class="form-control @error('hour_start') is-invalid @enderror" id="hour_start" name="hour_start">
        @error('hour_start')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="hour_end" class="form-label">Hour End</label>
        <input type="time" class="form-control @error('hour_end') is-invalid @enderror" id="hour_end" name="hour_end">
        @error('hour_end')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="availability_type_id" class="form-label">Availability Type</label>
        <select class="form-select @error('availability_type_id') is-invalid @enderror" id="availability_type_id" name="availability_type_id">
            @foreach($availabilityTypes as $availabilityType)
                <option value="{{ $availabilityType->id }}">{{ $availabilityType->name }}</option>
            @endforeach
        </select>
        @error('availability_type_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="mb-3">
        <label for="course_class_id" class="form-label">Course Class</label>
        <select class="form-select @error('course_class_id') is-invalid @enderror" id="course_class_id" name="course_class_id">
            @foreach($courseClasses as $courseClass)
                <option value="{{ $courseClass->id }}">{{ $courseClass->id }} - {{ $courseClass->name }}</option>
            @endforeach
        </select>
        @error('course_class_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ufcd_id" class="form-label">UFCD</label>
        <select class="form-select @error('ufcd_id') is-invalid @enderror" id="ufcd_id" name="ufcd_id">
            @foreach($ufcds as $ufcd)
                <option value="{{ $ufcd->id }}">{{ $ufcd->name }}</option>
            @endforeach
        </select>
        @error('ufcd_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
