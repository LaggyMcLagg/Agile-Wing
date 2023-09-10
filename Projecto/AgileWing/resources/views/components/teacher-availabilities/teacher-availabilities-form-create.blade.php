<form action="{{ route('teacher-availabilities.store') }}" method="POST">
    @csrf
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

    <div class="mb-3">
        <label for="availability_date" class="form-label">Availability Date</label>
        <input type="date" class="form-control @error('availability_date') is-invalid @enderror" id="availability_date" name="availability_date">
        @error('availability_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="is_locked" class="form-label">Is Locked</label>
        <input type="checkbox" class="form-check-input @error('is_locked') is-invalid @enderror" id="is_locked" name="is_locked">
        @error('is_locked')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="hour_block_id" class="form-label">Hour Block</label>
        <select class="form-select @error('hour_block_id') is-invalid @enderror" id="hour_block_id" name="hour_block_id">
            @foreach($hourBlocks as $hourBlock)
                <option value="{{ $hourBlock->id }}">{{ $hourBlock->hour_beginning }} - {{ $hourBlock->hour_end }}</option>
            @endforeach
        </select>
        @error('hour_block_id')
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

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
