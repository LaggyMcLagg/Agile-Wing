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

            <!-- Create Form -->
            <div id="createFormCont" style="{{ $isEditing ? 'display: none;' : '' }}">
                <form id="createForm" method="POST" action="{{ route('teacher-availabilities.store') }}">
                    @csrf

                    <!-- Hidden field for user ID -->
                    <input type="hidden" name="user_id" value="{{ $userId }}">

                    <div class="form-row">
                        <div class="col-12">
                            <label>Desde: (para registo uníco apenas preencher esta linha)</label>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="startDate" name="start_date" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control @error('start_hour_block_id') is-invalid @enderror" id="startHourBlock" name="start_hour_block_id">
                                    @foreach($hourBlocks as $block)
                                        <option value="{{$block->id}}" {{ old('start_hour_block_id') == $block->id ? 'selected' : '' }}>{{$block->hour_beginning}}-{{$block->hour_end}}</option>
                                    @endforeach
                                </select>
                                @error('start_hour_block_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12">
                            <label>Até:</label>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="endDate" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control @error('end_hour_block_id') is-invalid @enderror" id="endHourBlock" name="end_hour_block_id">
                                    @foreach($hourBlocks as $block)
                                        <option value="{{$block->id}}" {{ old('end_hour_block_id') == $block->id ? 'selected' : '' }}>{{$block->hour_beginning}}-{{$block->hour_end}}</option>
                                    @endforeach
                                </select>
                                @error('end_hour_block_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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

                    <button id="createFormBtn" type="submit" class="btn btn-primary">Criar</button>
                    <button id="cancelBtnCreate" type="button" class="btn btn-secondary ml-2" >Cancelar</button>
                </form>

            </div>

           <!-- Edit form -->
            <div id="editFormCont" style="{{ $isEditing ? '' : 'display: none;' }}">
                <form id="editForm" method="POST" action="{{ route('teacher-availabilities.store') }}">
                    @csrf

                    @method('PUT')
                    
                    <!-- Hidden field for user ID -->
                    <input type="hidden" name="user_id" value="{{ $userId }}">

                    <div class="form-group">
                        <label for="date">Data</label>
                        <input 
                            type="date" 
                            class="form-control @error('availability_date') is-invalid @enderror" 
                            id="date" 
                            name="availability_date" 
                            value="{{ old('availability_date', $isEditing ? $teacherAvailability->availability_date->format('Y-m-d') : '') }}">
                        @error('availability_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hourBlock">Bloco de horário</label>
                        <select class="form-control @error('hour_block_id') is-invalid @enderror" id="hourBlock" name="hour_block_id">
                            @foreach($hourBlocks as $block)
                                <option 
                                    value="{{$block->id}}" 
                                    {{ old('hour_block_id', $isEditing ? $teacherAvailability->hour_block_id : '') == $block->id ? 'selected' : '' }}>
                                    {{$block->hour_beginning}}-{{$block->hour_end}}
                                </option>
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
                                <option 
                                    value="{{$type->id}}" 
                                    {{ old('availability_type_id', $isEditing ? $teacherAvailability->availability_type_id : '') == $type->id ? 'selected' : '' }}>
                                    {{$type->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('availability_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button id="editFormBtn" type="submit" class="btn btn-primary">Alterar</button>
                    <button id="cancelBtnEdit" type="button" class="btn btn-secondary ml-2" >Cancelar</button>
                </form>
            </div>
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
        const baseUrl = sessionStorage.getItem('baseUrl');
        const formHeader = document.querySelector('#crudFormHeader');
        const liElements = document.querySelectorAll('li.list-group-item');
        
        //Edit form
        const editFormCont = document.querySelector('#editFormCont');
        const editForm = document.querySelector('#editForm');
        const submitButton = editForm.querySelector('#editFormBtn');
        const cancelButtonEdit = editForm.querySelector('#cancelBtnEdit');
        const dateInput = editForm.querySelector('#date');
        const hourBlockSelect = editForm.querySelector('#hourBlock');
        const availabilityTypeSelect = editForm.querySelector('#availabilityType');
        
        //create form
        const createFormCont = document.querySelector('#createFormCont');
        const createForm = document.querySelector('#createForm');
        const startDateInput = createForm.querySelector('#startDate');
        const startHourBlockSelect = createForm.querySelector('#startHourBlock');
        const cancelButtonCreate = createForm.querySelector('#cancelBtnCreate');
        const endDateInput = createForm.querySelector('#endDate');
        const endHourBlockSelect = createForm.querySelector('#endHourBlock');
        const availabilityTypeCreateSelect = createForm.querySelector('#availabilityType');

        // Show Edit Form and Hide Create Form
        const showEditForm = () => {
            createFormCont.style.display = "none";
            editFormCont.style.display = "";
        };

        // Show Create Form and Hide Edit Form
        const showCreateForm = () => {
            createFormCont.style.display = "";
            editFormCont.style.display = "none";
        };

        liElements.forEach(li => {
            li.addEventListener('click', function() {
                // Set form values based on clicked li
                dateInput.value = li.getAttribute('data-date');
                hourBlockSelect.value = li.getAttribute('data-hour-block-id');
                availabilityTypeSelect.value = li.getAttribute('data-type');

                // Change form to "edit" state
                const availabilityId = li.getAttribute('data-id');
                editForm.action = baseUrl + '/' + availabilityId;
                formHeader.textContent = "Edição";

                showEditForm();
            });
        });

        // edit Cancel button
        cancelButtonEdit.addEventListener('click', function() {
            dateInput.value = '';
            hourBlockSelect.selectedIndex = 0;
            availabilityTypeSelect.selectedIndex = 0;
            formHeader.textContent = "Criação"
            showCreateForm();
        });

        // Create Cancel button
        cancelButtonCreate.addEventListener('click', function() {
            startDateInput.value = '';
            startHourBlockSelect.selectedIndex = 0;
            endDateInput.value = '';
            endHourBlockSelect.selectedIndex = 0;
            availabilityTypeCreateSelect.selectedIndex = 0;
        });
    });
</script>