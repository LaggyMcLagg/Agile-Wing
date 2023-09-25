<h3>Lista de Blocos de Horário - LIST</h3>
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container" id = "listForm">
    <div class="row"> 
        <div class="col-md-6"> 
<!-- LIST/EDIT FORM / LIST FORM / LIST FORM -->
        <form id="editForm" method="PUT" action="{{ route('hour-blocks.update', ['id' => $defaultHourBlock->id]) }}">
            <!-- input oculto para armazenar o id do hourBlock a editar -->
        <input type="hidden" id="hourBlockIdEdit" name="hourBlockId">

                @csrf
                <!-- label para armazenar o id do hourBlock selecionado para verificar que metodo faz guardar/editar -->
                    <label for="id">ID: LIST/EDIT FORM</label>
                    <label id="id_labelEdit"></label>
                <div class="form-group">
                    <label for="hour_beginning">Hora de início</label>
                    <input
                        type="text"
                        id="hour_beginningEdit"
                        name="hour_beginning"
                        autocomplete="hour_beginning"
                        class="form-control @error('hour_beginning') is-invalid @enderror"
                        required
                        aria-describedby="hour_beginningHelp"
                        readonly
                    >
                    @error('hour_beginning')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hour_end">Hora de fim</label>
                    <input
                        type="text"
                        id="hour_endEdit"
                        name="hour_end"
                        autocomplete="hour_end"
                        class="form-control @error('hour_end') is-invalid @enderror"
                        required
                        aria-describedby="hour_endHelp"
                        readonly
                    >
                    @error('hour_end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button id="saveBtnEditForm" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtnEditForm" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
<!-- LIST/EDIT FORM / LIST FORM / LIST FORM -->


<!-- CREATE FORM / CREATE FORM / CREATE FORM -->
<form id="createForm" style="display: none;" method="POST" action="{{ url('hour-blocks') }}">
                @csrf
                <!-- label para armazenar o id do hourBlock selecionado para verificar que metodo faz guardar/editar -->
                    <label for="id">ID: CREATE FORM</label>
                    <label id="id_labelCreate"></label>
                <div class="form-group">
                    <label for="hour_beginning">Hora de início</label>
                    <input
                        type="text"
                        id="hour_beginningCreate"
                        name="hour_beginning"
                        autocomplete="hour_beginning"
                        class="form-control @error('hour_beginning') is-invalid @enderror"
                        required
                        aria-describedby="hour_beginningHelp"
                        readonly
                    >
                    @error('hour_beginning')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hour_end">Hora de fim</label>
                    <input
                        type="text"
                        id="hour_endCreate"
                        name="hour_end"
                        autocomplete="hour_end"
                        class="form-control @error('hour_end') is-invalid @enderror"
                        required
                        aria-describedby="hour_endHelp"
                        readonly
                    >
                    @error('hour_end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button id="saveBtnCreateForm" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtnCreateForm" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
<!-- CREATE FORM / CREATE FORM / CREATE FORM -->


        </div>
        <div class="col-md-6">
            <h5>Lista de Blocos</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-row">
                            <th scope="col">ID</th>
                            <th scope="col">Hora início</th>
                            <th scope="col">Hora de fim</th>
                            <th scope="col">
                                <a id="createBtn" class="btn btn-primary">Criar</a>
                                <a id="editBtn" type="button" class="btn btn-primary">Editar</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hourBlocks as $hourBlock)
                        <tr class="table-row">
                            <td>{{ $hourBlock->id }}</td>
                            <td>{{ $hourBlock->hour_beginning }}</td>
                            <td>{{ $hourBlock->hour_end }}</td>
                            <td>
                                <form action="{{ url('hour-blocks/' . $hourBlock->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer apagar este registo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Apagar bloco</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const editBtn = document.getElementById("editBtn"); 
        const createBtn = document.getElementById("createBtn");
        const saveBtnEditForm = document.getElementById("saveBtnEditForm"); 
        const saveBtnCreateForm = document.getElementById("saveBtnCreateForm"); 
        const cancelBtnEditForm = document.getElementById("cancelBtnEditForm");
        const cancelBtnCreateForm = document.getElementById("cancelBtnCreateForm");
        const editForm = document.getElementById("editForm");
        const createForm = document.getElementById("createForm");
        const idLabel = document.getElementById("id_labelEdit");
        const hourBeginningInput = document.getElementById("hour_beginningEdit");
        const hourEndInput = document.getElementById("hour_endEdit");
        const tableRows = document.querySelectorAll(".table-row");

        cancelBtnEditForm.addEventListener("click", clearForm);

        //in case of refresh and or cancel
        function clearForm() {
            idLabel.innerText = "";
            hourBeginningInput.value = "";
            hourEndInput.value = "";            
        };
        clearForm();



        // Variável para rastrear o estado de edição
        let isEditing = false;

        // Função para habilitar a edição dos campos
        function enableEdit() {
            // Habilita a edição dos campos e desabilita os botões de exclusão
            document.querySelectorAll("input[readonly]").forEach(function (input) {
                input.removeAttribute("readonly");
                input.classList.remove("form-control-plaintext");
            });

            saveBtnEditForm.style.display = "inline-block"; // Mostrar o botão "Guardar"
            cancelBtnEditForm.style.display = "inline-block";
            isEditing = true;
        }

        // Adicione um ouvinte de evento de clique ao botão de edição
        editBtn.addEventListener("click", function () {
            if (!isEditing) {
                enableEdit();
            }
        });

        createBtn.addEventListener("click", function(){
            clearForm();
            enableEdit();
            editForm.style.display="none";
            createForm.style.display = "block";
            saveBtnCreateForm.style.display = "inline-block";
            cancelBtnCreateForm.style.display = "inline-block";
        })

        // Cancel button functionality
        cancelBtnEditForm.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission

            // Clear form fields
            clearForm();

            // Disable the edit mode and hide the buttons
            isEditing = false;
            saveBtnEditForm.style.display = "none";
            cancelBtnEditForm.style.display = "none";

            // Re-enable the read-only attribute of the input fields
            document.querySelectorAll("input").forEach(function (input) {
                input.setAttribute("readonly", true);
                input.classList.add("form-control-plaintext");
            });
        });


        cancelBtnCreateForm.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission

            // Clear form fields
            clearForm();

            // Disable the edit mode and hide the buttons
            isEditing = false;
            saveBtnCreateForm.style.display = "none";
            cancelBtnCreateForm.style.display = "none";
            editForm.style.display="block";
            createForm.style.display="none";


            // Re-enable the read-only attribute of the input fields
            document.querySelectorAll("input").forEach(function (input) {
                input.setAttribute("readonly", true);
                input.classList.add("form-control-plaintext");
            });
        });

        // Adicione um ouvinte de evento de clique às linhas da tabela
        tableRows.forEach(function (row) {
            row.addEventListener("click", function () {
                if (!isEditing) {
                    // Verifique se a edição não está ativada
                    // Obtém os dados da linha clicada
                    const cells = row.getElementsByTagName("td");
                    const id = cells[0].textContent;
                    const hourBeginning = cells[1].textContent;
                    const hourEnd = cells[2].textContent;

                    // Preenche os campos à esquerda com os dados
                    document.getElementById("id_labelEdit").innerText  = id;
                    document.getElementById("hour_beginningEdit").value = hourBeginning;
                    document.getElementById("hour_endEdit").value = hourEnd;
                    //obtém o id do hourBlock a editar para fazer a distinção se faz o método store ou update
                    document.getElementById("hourBlockIdEdit").value = id;
                }
            });
        });

    });
</script>
