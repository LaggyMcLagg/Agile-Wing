<form method="POST" action="{{ url('user-type') }}">
@csrf
    <div class="form-group">
        <label for="name">Tipo de utilizador:</label>
        <input type="text"
        id="name"
        name="name"
        autocomplete="name"
        placeholder="{{ $userType->name }}"
        class="form-control
        @error('name') is-invalid @enderror" value="{{ old('name') }}" required aria-describedby="nameHelp" readonly>
        @error('name')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Data da criação</label>
        <input type="text"
        id="created_at"
        name="created_at"
        autocomplete="created_at"
        placeholder="{{ $userType->created_at }}"
        class="form-control
        @error('created_at') is-invalid @enderror" value="{{ old('created_at') }}" required aria-describedby="created_atHelp" readonly>
        @error('created_at')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Data da última modificação</label>
        <input type="text"
        id="updated_at"
        name="updated_at"
        autocomplete="updated_at"
        placeholder="{{ $userType->updated_at }}"
        class="form-control
        @error('updated_at') is-invalid @enderror" value="{{ old('updated_at') }}" required aria-describedby="updated_atHelp" readonly>
        @error('updated_at')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

<a href="/bicycles" class="mt-2 mb-5 btn btn-primary">Back to List</a>