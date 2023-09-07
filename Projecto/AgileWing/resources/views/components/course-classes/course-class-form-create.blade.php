<form method="POST" action="{{ url('course-classes') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" autocomplete="name" placeholder="Insert Name" class="form-control
 @error('name') is-invalid @enderror" value="{{ old('name') }}" required aria-describedby="nameHelp">
        <small id="nameHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="number">Number</label>
        <input type="text" id="number" name="number" autocomplete="number" placeholder="Inser Number" class="form-control
 @error('number') is-invalid @enderror" value="{{ old('number') }}" required aria-describedby="numberHelp">
        <small id="numberHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>
        @error('number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="form-group">
        <label for="courseId">Course ID</label>
        <input type="text" id="courseId" name="courseId" autocomplete="courseId" placeholder="Inser Course ID" class="form-control
 @error('courseId') is-invalid @enderror" value="{{ old('courseId') }}" required aria-describedby="courseIdHelp">
        <small id="courseIdHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>
        @error('courseId')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
</form>