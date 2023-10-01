<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Pedagogical Group New
        </div>
        <form action="{{ route('pedagogical-groups.store') }}" method="POST" class="p-3">
            @csrf

            <div class="form-group">
                <label for="number">Number</label>
                <input type="number" id="number" name="number" autocomplete="number" placeholder="{{ $pedagogicalGroup->number }}" class="form-control
 @error('number') is-invalid @enderror" value="{{ old('number') }}">
                @error('number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" autocomplete="name" placeholder="{{ $pedagogicalGroup->name }}" class="form-control
 @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
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