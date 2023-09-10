<form action="{{ route('teacher-availabilities.update', $teacherAvailability->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Availability Date -->
    <div class="mb-3">
        <label for="availability_date" class="form-label">Availability Date</label>
        <input type="date" class="form-control @error('availability_date') is-invalid @enderror" id="availability_date" name="availability_date" value="{{ $teacherAvailability->availability_date->format('Y-m-d') }}">
        @error('availability_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Is Locked -->
    <div class="mb-3">
        <label for="is_locked" class="form-label">Is Locked</label>
        <input type="checkbox" class="form-control" id="is_locked" name="is_locked" value="1" @if($teacherAvailability->is_locked) checked @endif>
    </div>

    <!-- User ID -->
    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}" @if($user->id == $teacherAvailability->user_id) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Hour Block ID -->
    <div class="mb-3">
        <label for="hour_block_id" class="form-label">Hour Block</label>
        <select class="form-control @error('hour_block_id') is-invalid @enderror" id="hour_block_id" name="hour_block_id">
            @foreach($hourBlocks as $hourBlock)
                <option value="{{ $hourBlock->id }}" @if($hourBlock->id == $teacherAvailability->hour_block_id) selected @endif>
                    {{ $hourBlock->hour_beginning }} - {{ $hourBlock->hour_end }}
                </option>
            @endforeach
        </select>
        @error('hour_block_id')
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
                <option value="{{ $availabilityType->id }}" @if($availabilityType->id == $teacherAvailability->availability_type_id) selected @endif>
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

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Update</button>
</form>
