@section('styles')
<!-- SARA dps retira isto para o teu ficheiro css -->
<style>
.scrollable-col {
    max-height: 500px;
    overflow-y: auto;
}

.square-badge {
    width: 20px;
    height: 20px;
    display: inline-block;
    vertical-align: middle;
}
</style>
@endsection

@section('scripts')
<!-- this way the routes used in the js are allways updated and nor hardcoded -->
<script>
    sessionStorage.setItem('deleteSelectedRoute', '{{ route('teacher-availabilities.delete-selected') }}');
    sessionStorage.setItem('publishSelectedRoute', '{{ route('teacher-availabilities.publish-selected') }}');
    sessionStorage.setItem('baseUrl', '{{ route('teacher-availabilities.store') }}');
</script>
@endsection

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="container">
    <div class="row">
        <!-- First Column: Collapsible Dates -->
        <div class="col-md-4">
            <h3> <input type="checkbox" id="selectAll"> Lista de marcações</h3>
            <form id="bulkActionForm" method="post">
            @csrf
                <div class= "scrollable-col">
                    <div class="accordion" id="datesAccordion">
                        @foreach($teacherAvailabilitiesGroupedByDate as $date => $availabilities)
                            <div class="card">
                                <div class="card-header" id="heading{{$loop->index}}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                                            {{$date}}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse{{$loop->index}}" class="collapse" aria-labelledby="heading{{$loop->index}}" data-parent="#datesAccordion">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach($availabilities as $availability)
                                            <li data-date="{{$date}}" data-id="{{$availability->id}}" data-hour-block-id="{{$availability->hourBlock->id}}" data-type="{{$availability->availabilityType->id}}" class="list-group-item d-flex justify-content-between align-items-center">
                                                <input type="checkbox" class="availability-checkbox" value="{{$availability->id}}">
                                                {{$availability->hourBlock->hour_beginning}}-{{$availability->hourBlock->hour_end}}
                                                <div class="square-badge" style="background-color: {{$availability->availabilityType->color}};"></div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn btn-light" id="deleteBtn">Apagar</button>
                <button type="button" class="btn btn-light" id="publishBtn">Publicar</button>
            </form>
        </div>

        <!-- Second Column: Availability Details -->
        <div class="col-md-8">
            <h3 id="crudFormHeader">{{ $isEditing ? 'Edição' : 'Criação' }}</h3>
            <form id="crudForm" method="POST" action="{{ route('teacher-availabilities.store') }}">
                @csrf
                
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                 <!-- Hidden field for user ID -->
                <input type="hidden" name="user_id" value="{{ $userId }}">

                <div class="form-group">
                    <label for="date">Data</label>
                    <input type="date" class="form-control @error('availability_date') is-invalid @enderror" id="date" name="availability_date" value="{{ old('availability_date') }}">
                    @error('availability_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hourBlock">Bloco de horário</label>
                    <select class="form-control @error('hour_block_id') is-invalid @enderror" id="hourBlock" name="hour_block_id">
                        @foreach($hourBlocks as $block)
                            <option value="{{$block->id}}" {{ old('hour_block_id') == $block->id ? 'selected' : '' }}>{{$block->hour_beginning}}-{{$block->hour_end}}</option>
                        @endforeach
                    </select>
                    @error('hour_block_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="availabilityType">Tipo de disponibilidade</label>
                    <select class="form-control @error('availability_type_id') is-invalid @enderror" id="availabilityType" name="availability_type_id">
                        @foreach($availabilityTypes as $type)
                            <option value="{{$type->id}}" {{ old('availability_type_id') == $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                        @endforeach
                    </select>
                    @error('availability_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button id="crudFormBtn" type="submit" class="btn btn-primary">Submit</button>
                <button id="cancelBtn" type="button" class="btn btn-secondary ml-2" >Cancel</button>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteSelectedRoute = sessionStorage.getItem('deleteSelectedRoute');
        const publishSelectedRoute = sessionStorage.getItem('publishSelectedRoute');
        const selectAllCheckbox = document.getElementById('selectAll');
        const availabilityCheckboxes = document.querySelectorAll('.availability-checkbox');
        const deleteBtn = document.getElementById('deleteBtn');
        const publishBtn = document.getElementById('publishBtn');

        // Select/Deselect all functionality
        selectAllCheckbox.addEventListener('change', function() {
            availabilityCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Delete functionality
        deleteBtn.addEventListener('click', function() {
            const selectedIds = [...availabilityCheckboxes].filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = selectedIds;
            document.getElementById('bulkActionForm').appendChild(input);
            console.log(selectedIds);
            
            document.getElementById('bulkActionForm').action = deleteSelectedRoute;
            document.getElementById('bulkActionForm').submit();
        });

        // Publish functionality
        publishBtn.addEventListener('click', function() {
            const selectedIds = [...availabilityCheckboxes].filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = selectedIds;
            document.getElementById('bulkActionForm').appendChild(input);
            console.log(selectedIds);
            
            document.getElementById('bulkActionForm').action = publishSelectedRoute;
            document.getElementById('bulkActionForm').submit();
        });
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const baseUrl = sessionStorage.getItem('baseUrl'); //default is POST create
        const liElements = document.querySelectorAll('li.list-group-item');

        const formHeader = document.querySelector('#crudFormHeader');

        const form = document.querySelector('#crudForm');
        const submitButton = form.querySelector('#crudFormBtn');
        const cancelButton = form.querySelector('#cancelBtn');
        const dateInput = form.querySelector('#date');
        const hourBlockSelect = form.querySelector('#hourBlock');
        const availabilityTypeSelect = form.querySelector('#availabilityType');

        // Create Cancel button
        cancelButton.addEventListener('click', function() {
            // Reset form state to "create"
            form.action = baseUrl;
            form.method = 'POST';
            dateInput.value = '';
            hourBlockSelect.selectedIndex = 0;
            availabilityTypeSelect.selectedIndex = 0;
            submitButton.textContent = "Criar";
            formHeader.textContent = "Criação"
            document.getElementById('hiddenMethod').value = 'POST';
        });

        liElements.forEach(li => {
            li.addEventListener('click', function() {
                console.log("List item clicked");
                // Set form values based on clicked li
                dateInput.value = li.getAttribute('data-date');
                hourBlockSelect.value = li.getAttribute('data-hour-block-id');
                availabilityTypeSelect.value = li.getAttribute('data-type');

                // Change form to "edit" state
                const availabilityId = li.getAttribute('data-id');
                form.action = baseUrl + '/' + availabilityId;
                document.getElementById('hiddenMethod').value = 'PUT';
                submitButton.textContent = "Alterar";
                formHeader.textContent = "Edição";
            });
        });
    });

</script>