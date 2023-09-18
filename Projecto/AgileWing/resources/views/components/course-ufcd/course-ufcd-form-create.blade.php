<form action="{{ route('course-ufcd.store') }}" method="POST">
    @csrf


    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-select @error('course_id') is-invalid @enderror" id="course_id" name="course_id">
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
        @error('course_id')
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


    <button type="submit" class="btn btn-primary">Submit</button>
</form>
