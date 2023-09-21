<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Teacher Availability New
        </div>
        <form action="{{ route('teacher-availabilities.store') }}" method="POST" class="p-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }}</option>
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
                    <label for="pedagogicalGroup_id" class="form-label">Pedagogical Group</label>
                    <select class="form-select @error('pedagogicalGroup_id') is-invalid @enderror" id="pedagogicalGroup_id" name="pedagogicalGroup_id">
                        @foreach($pedagogicalGroups as $pedagogicalGroup)
                            <option value="{{ $pedagogicalGroup->id }}">{{ $pedagogicalGroup->id }} - {{ $pedagogicalGroup->name }}</option>
                        @endforeach
                    </select>
                    @error('pedagogicalGroup_id')
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
