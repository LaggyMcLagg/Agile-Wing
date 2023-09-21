<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Pedagogical Group User Edit
        </div>
        <form action="{{ route('pedagogical-group-users.update', $pedagogicalGroupUser->id) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($user->id == $pedagogicalGroupUser->user_id) selected @endif>{{ $user->name }}</option>
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
                    <label for="pedagogical_group_id" class="form-label">Pedagogical Group</label>
                    <select class="form-select @error('pedagogical_group_id') is-invalid @enderror" id="pedagogical_group_id" name="pedagogical_group_id">
                        @foreach($pedagogicalGroups as $pedagogicalGroup)
                            <option value="{{ $pedagogicalGroup->id }}" @if($pedagogicalGroup->id == $pedagogicalGroupUser->pedagogical_group_id) selected @endif>{{ $pedagogicalGroup->name }}</option>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
