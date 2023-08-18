<form method="POST" action="{{ url('formadores/' . $user->id) }}">
@csrf
@method('PUT')
<div class="form-group">
        <label for="name">ID</label>
        <input
            type="text"
            id="id"
            name="id"
            autocomplete="id"
            placeholder="User ID"
            class="form-control
            @error('id') is-invalid @enderror"
            value="{{ $user->id }}"
            required
            aria-describedby="idHelp">

    <small id="cityHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>

        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

<div class="form-group">
        <label for="name">Name</label>
        <input
            type="text"
            id="user"
            name="name"
            autocomplete="user"
            placeholder="Type user ID NAO SE PODE EDITAR"
            class="form-control
            @error('id') is-invalid @enderror"
            value="{{ $user->id }}"
            required
            aria-describedby="userHelp">

    <small id="userHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>

        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="name">Email</label>
        <input
            type="text"
            id="email"
            name="email"
            autocomplete="email"
            placeholder="Type pet's colour"
            class="form-control
            @error('email') is-invalid @enderror"
            value="{{ $user->email }}"
            required
            aria-describedby="emailHelp">

    <small id="cityHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="name">Date of Birth</label>
        <input
            type="date"
            id="date_of_birth"
            name="date_of_birth"
            autocomplete="date_of_birth"
            placeholder="Type date_of_birth"
            class="form-control
            @error('date_of_birth') is-invalid @enderror"
            value="{{ $pet->date_of_birth }}"
            required
            aria-describedby="date_of_birthHelp">

    <small id="date_of_birthHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>

        @error('date_of_birth')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>


<button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
</form>