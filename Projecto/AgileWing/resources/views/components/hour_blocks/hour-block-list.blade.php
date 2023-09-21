

<!--EM CONSTRUCAO MOVER PARA O hour-block-form-show como fiz com o user-form-show-->
<!-- DELETE não funciona -EM CONSTRUCAO MOVER PARA O hour-block-form-show como fiz com o user-form-show-->

<h3>List de Blocos</h3>
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form method="POST" action="{{ url('{hourBlock}') }}">
                @csrf
                    <label for="id">ID:</label>
                    <label id="id_label"></label>
                <div class="form-group">
                    <label for="hour_beginning">Hora de início</label>
                    <input
                        type="text"
                        id="hour_beginning"
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
                        id="hour_end"
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
                <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none;">Guardar</button>
                <button id="cancelBtn" class="mt-2 mb-5 btn btn-secondary" style="display: none;">Cancelar</button>
            </form>
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
                                <a href="{{ url('hour-blocks/create') }}" class="btn btn-primary">Criar</a>
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

        const tableRows = document.querySelectorAll(".table-row");
        const editBtn = document.getElementById("editBtn"); // Botão de edição
        const saveBtn = document.getElementById("saveBtn"); // Botão de salvar
        const idLabel = document.getElementById("id_label");
        const hourBeginningInput = document.getElementById("hour_beginning");
        const hourEndInput = document.getElementById("hour_end");

        const cancelButton = document.getElementById("cancelBtn");
        cancelButton.addEventListener("click", clearForm);

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

            saveBtn.style.display = "inline-block"; // Mostrar o botão "Guardar"
            cancelButton.style.display = "inline-block";
            isEditing = true;
        }

        // Adicione um ouvinte de evento de clique ao botão de edição
        editBtn.addEventListener("click", function () {
            if (!isEditing) {
                enableEdit();
            }
        });

        // Cancel button functionality
        cancelButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission

            // Clear form fields
            clearForm();

            // Disable the edit mode and hide the buttons
            isEditing = false;
            saveBtn.style.display = "none";
            cancelButton.style.display = "none";

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
                    document.getElementById("id_label").innerText  = id;
                    document.getElementById("hour_beginning").value = hourBeginning;
                    document.getElementById("hour_end").value = hourEnd;
                }
            });
        });

    });
</script>
