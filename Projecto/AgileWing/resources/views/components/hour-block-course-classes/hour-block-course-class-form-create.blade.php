<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            New Hour Block Course Class
        </div>
        <form action="{{ route('hour-block-course-classes.store') }}" method="POST" class="p-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="courseClass_id" class="form-label">Course ID</label>
                    <select class="form-select @error('courseClass_id') is-invalid @enderror" id="courseClass_id" name="courseClass_id">
                        @foreach($courseClasses as $courseClass)
                        <option value="{{ $courseClass->id }}">{{ $courseClass->id }}</option>
                        @endforeach
                    </select>
                    @error('courseClass_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="hourEnd">Hour Beginning</label>
                <input step="1" type="time" id="hourEnd" courseID="hourEnd" autocomplete="hourEnd" class="form-control
 @error('hourEnd') is-invalid @enderror" value="{{ old('hourEnd') }}">
                @error('hourEnd')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="hourEnd">Hour End</label>
                <input step="1" type="time" id="hourEnd" courseID="hourEnd" autocomplete="hourEnd" class="form-control
 @error('hourEnd') is-invalid @enderror" value="{{ old('hourEnd') }}">
                @error('hourEnd')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="row mb-3">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>