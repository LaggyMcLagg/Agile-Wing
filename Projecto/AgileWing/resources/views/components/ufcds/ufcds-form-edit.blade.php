<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            UFCD New
            <form action="{{ route('ufcds.update', $ufcd->id) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $ufcd->name}}">
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
                            <option value="{{ $pedagogicalGroup->id }}" @if( $pedagogicalGroup->id  == $ufcd->pedagogical_group_id) selected @endif>{{  $pedagogicalGroup->name}}</option>
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
                    <input type="number" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ $ufcd->number}}">
                    @error('number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="hours" class="form-label">Hours</label>
                    <input type="number" class="form-control @error('hours') is-invalid @enderror" id="hours" name="hours" value="{{ $ufcd->hours}}"> 
                    @error('hours')
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
