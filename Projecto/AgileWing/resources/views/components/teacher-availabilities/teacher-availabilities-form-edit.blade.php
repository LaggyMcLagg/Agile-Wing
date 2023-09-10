<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Teacher Availability Edit
        </div>
        <form action="{{ route('teacher-availabilities.update', $teacherAvailability->id) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="availability_date" class="form-label">Availability Date</label>
                    <input type="date" class="form-control @error('availability_date') is-invalid @enderror" id="availability_date" name="availability_date" value="{{ $teacherAvailability->availability_date->format('Y-m-d') }}">
                    @error('availability_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('is_locked') is-invalid @enderror" id="is_locked" name="is_locked" value="1" @if(old('is_locked', $teacherAvailability->is_locked)) checked @endif>
                        <label class="form-check-label" for="is_locked">Is Locked</label>
                        @error('is_locked')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
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
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="hour_block_id" class="form-label">Hour Block</label>
                    <select class="form-select @error('hour_block_id') is-invalid @enderror" id="hour_block_id" name="hour_block_id">
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
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="availability_type_id" class="form-label">Availability Type</label>
                    <select class="form-select @error('availability_type_id') is-invalid @enderror" id="availability_type_id" name="availability_type_id">
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
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
