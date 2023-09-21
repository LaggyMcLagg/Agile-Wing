<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            UFCD New
            <form action="{{ route('ufcds.store') }}" method="POST" class="p-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="pedagogical_group_id" class="form-label">Pedagogical Group Id</label>
                    <select class="form-select @error('pedagogical_group_id') is-invalid @enderror" id="pedagogical_group_id" name="pedagogical_group_id">
                        @foreach($pedagogicalGroups as $pedagogicalGroup)
                            <option value="{{ $pedagogicalGroup->id }}">{{ $pedagogicalGroup->id }}</option>
                        @endforeach
                    </select>
                    @error('pedagogical_group_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="number" class="form-label">Number</label>
                    <input type="number" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Hours</label>
                    <input type="number" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
