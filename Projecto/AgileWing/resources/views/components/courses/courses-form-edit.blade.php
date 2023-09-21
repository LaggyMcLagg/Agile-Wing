<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Course Edit
        </div>
        <form action="{{ route('courses.update', $course->id) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $course->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Initials -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="initials" class="form-label">Initials</label>
                    <input type="text" class="form-control @error('initials') is-invalid @enderror" id="initials" name="initials" value="{{ old('initials', $course->initials) }}">
                    @error('initials')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Specialization Area -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="specialization_area_number" class="form-label">Specialization Area</label>
                    <select class="form-select @error('specialization_area_number') is-invalid @enderror" id="specialization_area_number" name="specialization_area_number">
                        @foreach($specializationAreas as $specializationArea)
                            <option value="{{ $specializationArea->number }}" @if($specializationArea->number == old('specialization_area_number', $course->specialization_area_number)) selected @endif>
                                {{ $specializationArea->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('specialization_area_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- UFCDs -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">UFCDs</label>
                    @foreach($ufcds as $ufcd)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="ufcd{{ $ufcd->id }}" name="ufcds[]" value="{{ $ufcd->id }}" @if($course->ufcds->contains($ufcd->id)) checked @endif>
                            <label class="form-check-label" for="ufcd{{ $ufcd->id }}">{{ $ufcd->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
