<div class="container">
    <h3>Detalhes do Utilizador - é este que está a ser usado(user-form-show)</h3>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="id">ID</label>
                    <label
                        id="id"
                        name="id"
                        class="form-control">{{ $user->id }}</label>
                </div>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text"
                        id="name"
                        name="name"
                        autocomplete="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        aria-describedby="nameHelp"
                        readonly>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text"
                        id="email"
                        name="email"
                        autocomplete="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        aria-describedby="emailHelp"
                        readonly>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="color1">Cor 1</label>
                    <input
                        type="color"
                        id="color1"
                        name="color1"
                        class="form-control color-field @error('color1') is-invalid @enderror"
                        value="{{ $user->color_1 }}"
                        aria-describedby="color1Help">
                    @error('color1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="color2">Cor 2</label>
                    <input
                        type="color"
                        id="color2"
                        name="color2"
                        class="form-control color-field @error('color2') is-invalid @enderror"
                        value="{{ $user->color_2 }}"
                        aria-describedby="color2Help">
                    @error('color2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Grupos Pedagógicos</label>
                    @foreach($pedagogicalGroups as $pedagogicalGroup)
                        <div class="form-check">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="pedagogicalGroups[]" 
                                value="{{ $pedagogicalGroup->id }}" 
                                id="pedagogicalGroup_{{ $pedagogicalGroup->id }}"
                                @if($pedagogicalGroupUserList[$pedagogicalGroup->id]['isAssociated'])
                                    checked
                                @endif
                                disabled>
                            <label class="form-check-label" 
                                for="pedagogicalGroup_{{ $pedagogicalGroup->id }}">
                                {{ $pedagogicalGroup->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Áreas de Formação</label>
                    @foreach($specializationAreas as $specializationArea)
                        <div class="form-check">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="specializationAreas[]" 
                                value="{{ $specializationArea->number }}" 
                                id="specializationArea_{{ $specializationArea->number }}"
                                @if($specializationAreaUserList[$specializationArea->number]['isAssociated'])
                                    checked
                                @endif
                                disabled>
                            <label class="form-check-label" 
                                for="specializationArea_{{ $specializationArea->number }}">
                                {{ $specializationArea->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button id="saveBtn" type="submit" class="btn btn-primary" style="display: none;">Guardar</button>
        <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
    </form>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button id="editBtn" type="button" class="btn btn-primary">Editar</button>
            <form id="deleteForm" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Apagar Formador</button>
            </form>
    </div>
</div>

<script>  
    document.addEventListener("DOMContentLoaded", function(){
        const editBtn = document.getElementById("editBtn");
        const saveBtn = document.getElementById("saveBtn");
        const deleteForm = document.getElementById("deleteForm");
        const cancelBtn = document.getElementById("cancelBtn");


        editBtn.addEventListener("click", function(event){

            // Habilitar campos editáveis
            document.querySelectorAll("input[readonly]").forEach(function(input){
                input.removeAttribute("readonly");
            });
            document.querySelectorAll("input[type=checkbox]").forEach(function(checkbox){
                checkbox.removeAttribute("disabled");
            });

            // Mostrar botão "Guardar" e esconder o botão "Editar"
            editBtn.style.display = "none";
            saveBtn.style.display = "inline-block";
            deleteForm.style.display = "inline-block";
            cancelBtn.style.display = "inline-block";
        });

        cancelBtn.addEventListener("click", function (event) {
            event.preventDefault();
            // Desabilitar campos editáveis
            document.querySelectorAll("input").forEach(function (input) {
                input.setAttribute("readonly", true);
            });
            document.querySelectorAll("input[type=checkbox]").forEach(function (checkbox) {
                checkbox.setAttribute("disabled", true);
            });
        
            // Esconder botão "Guardar" e "Apagar" e mostrar o botão "Editar"
            editBtn.style.display = "inline-block";
            saveBtn.style.display = "none";
            deleteForm.style.display = "none";
            cancelBtn.style.display = "none";
        });
    });
</script>


