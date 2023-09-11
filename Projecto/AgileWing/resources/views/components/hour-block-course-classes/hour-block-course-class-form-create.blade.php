<form method="POST" action="{{ url('course-classes') }}">
    @csrf

    <div class="form-group">
        <label for="courseID">Course ID</label>
        <input type="number" id="courseID" courseID="courseID" autocomplete="courseID" class="form-control
 @error('courseID') is-invalid @enderror" value="{{ old('courseID') }}">
        @error('courseID')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
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

    <button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
</form>