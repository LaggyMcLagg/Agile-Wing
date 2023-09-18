<form action="{{ route('course-ufcd.update', $courseUfcd->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Course_id -->
    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id">
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @if($course->id == $courseUfcd->course_id) selected @endif>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
        @error('course_id')
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
                <option value="{{ $ufcd->id }}" @if($ufcd->id == $courseUfcd->ufcd_id) selected @endif>
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


    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Update</button>
</form>
