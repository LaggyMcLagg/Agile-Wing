<form method="POST" action="{{ url('course-classes') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" autocomplete="name" placeholder="Insert Name" class="form-control
 @error('name') is-invalid @enderror" value="{{$courseClass->name }}">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="number">Number</label>
        <input type="text" id="number" name="number" autocomplete="number" placeholder="Inser Number" class="form-control
 @error('number') is-invalid @enderror" value="{{$courseClass->number}}">
        @error('number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

     <!-- Country ComboBox -->
     <div class="form-group">
        <label for="course_id">Course</label>
        <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
            <option value="">Select a Course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @if($course->id == $courseClass->course_id) selected @endif>{{ $course->name }}
                </option>
            @endforeach
        </select>
        @error('course_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
</form>