@section('scripts')
<script src="{{ asset('/js/control-form-dynamic-crud.js') }}"></script>
@endsection

(...)

<!-- Start of the Main Container -->
<div class="container" id="listForm">
    <div class="row"> 
        <!-- LEFT COLUMN: CREATE/EDIT FORM -->
        <div class="col-md-4"> 

            <h3>Gestão de Cursos</h3>
            <!-- FORM -->
            <form action="{{ route('courses.store') }}" id="controlForm" method="POST">
                @csrf

                <!-- Hidden input for HTTP method override. Needed because HTML forms only support GET/POST natively and we're not using 
                @method('PUT') to be able to switch between methods-->
                <input type="hidden" name="_method" value="POST" id="hiddenMethod">

                <!-- Course ID -->
                <label for="id">Course ID: </label>
                <!-- The prop data-name tells js where to target to place the info collected from the table -->
                <label data-name="id" id="id_label"></label>

                <!-- Course Name -->
                (...)

                <!-- Course Initials -->
                (...)

                <!-- Specialization Area -->
                <div class="form-group">
                <label for="specializationArea">Specialization Area</label>
                <select 
                    data-name="specializationArea"
                    data-type="comboBox" 
                    id="specializationArea" 
                    name="specialization_area_number" 
                    class="form-control"
                    disabled>
                    @foreach($specializationAreas as $area)
                        <option value="{{ $area->number }}" 
                            @if(old('specialization_area_number') == $area->number) selected @endif
                        >
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

                <!-- UFCDs checkbox list -->
                <div class="form-group">
                    <label>UFCDs 
                        <button 
                            class="btn btn-light btn-sm d-flex align-items-center" 
                            type="button" 
                            data-toggle="collapse" 
                            data-target="#ufcdsCheckboxList">
                            <i class="fas fa-chevron-right mr-2"></i> Show/Hide
                        </button>
                    </label>
                    <div 
                        id="ufcdsCheckboxList" 
                        data-name="ufcds" 
                        data-type="checkBoxList" 
                        class="collapse mt-2">
                        @foreach($ufcds as $ufcd)
                            <div class="custom-control custom-checkbox">
                                <input 
                                    type="checkbox" 
                                    name="ufcds[]" 
                                    value="{{ $ufcd->id }}" 
                                    id="ufcd_{{ $ufcd->id }}"
                                    class="custom-control-input @error('ufcds') is-invalid @enderror"
                                    @if(is_array(old('ufcds')) && in_array($ufcd->id, old('ufcds'))) checked @endif
                                    disabled>
                                <label for="ufcd_{{ $ufcd->id }}" class="custom-control-label">{{ $ufcd->name }}</label>
                            </div>
                        @endforeach
                        @error('ufcds')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Save and Cancel buttons, initially hidden -->
                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
        </div>

        <!-- TABELA LIST/SHOW -->
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    (...)
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    <tr>
                        (...)
                        <td data-name="specializationArea">{{ $course->specializationArea->name }}</td>
                        (...)
                        <td data-name="ufcds">
                            <button 
                                class="btn btn-light" 
                                type="button" 
                                data-toggle="collapse" 
                                data-target="#ufcdsList_{{ $course->id }}">
                                UFCDs
                            </button>
                            <div id="ufcdsList_{{ $course->id }}" class="collapse">
                                <ul>
                                    @forelse($course->ufcds as $ufcd)
                                        <li value="{{ $ufcd->id }}">{{ $ufcd->name }}</li>
                                    @empty
                                        <li value="-1">No UFCDs associated yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ route('courses.destroy', ['course' => $course]) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Apagar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>