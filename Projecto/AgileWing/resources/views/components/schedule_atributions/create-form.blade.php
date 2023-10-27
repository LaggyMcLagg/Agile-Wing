<form action="{{ route('schedule-atribution.store') }}" method="post">
    @csrf

    <!-- Checkbox for "Presencial" -->
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="presencial" name="presencial" checked>
        <label class="form-check-label" for="presencial">Presencial</label>
    </div>

    <!-- List of Compatible Users -->
    <div class="form-group">
        <label for="users">Compatible Users</label>
        <select class="form-control" id="users" name="user_id">
            @foreach($filteredUsers as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- List of Compatible UFCDs -->
    <div class="form-group">
        <label for="ufcds">Compatible UFCDs</label>
        <select class="form-control" id="ufcds" name="ufcd_id">
            @foreach($ufcds as $ufcd)
                <option value="{{ $ufcd->id }}">{{ $ufcd->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
