

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
            <form method="POST" action="{{ url('hour-blocks') }}">
                @csrf
                <div class="form-group">
                    <label for="id">ID</label>
                    <input
                        type="text"
                        id="id"
                        name="id"
                        class="form-control"
                        readonly
                        value="{{ $hourBlock->id }}"
                    >
                </div>


                <div class="form-group">
                    <label for="hour_beginning">Hora de início</label>
                    <input
                        type="text"
                        id="hour_beginning"
                        name="hour_beginning"
                        autocomplete="hour_beginning"
                        placeholder="{{ $hourBlock->hour_beginning }}"
                        class="form-control @error('hour_beginning') is-invalid @enderror"
                        value="{{ old('hour_beginning') }}"
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
                        placeholder="{{ $hourBlock->hour_end }}"
                        class="form-control @error('hour_end') is-invalid @enderror"
                        value="{{ old('hour_end') }}"
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
                                <form action="{{ url('hour-blocks/' . $hourBlock->id) }}" method="POST">
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
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <button id="saveBtn" type="submit" class="mt-2 mb-5 btn btn-primary" style="display: none";>Guardar</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tableRows = document.querySelectorAll(".table-row");
        const editBtn = document.getElementById("editBtn"); // Botão de edição
        const saveBtn = document.getElementById("saveBtn"); // Botão de salvar

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
            isEditing = true;
        }

        // Adicione um ouvinte de evento de clique ao botão de edição
        editBtn.addEventListener("click", function () {
            if (!isEditing) {
                enableEdit();
            }
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
                    document.getElementById("id").value = id;
                    document.getElementById("hour_beginning").value = hourBeginning;
                    document.getElementById("hour_end").value = hourEnd;
                }
            });
        });
    });
</script>











<!-- DELETE não funciona -EM CONSTRUCAO MOVER PARA O hour-block-form-show como fiz com o user-form-show-->


<!-- ORGINAL -->

<h3>List de Blocos</h3>
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Hora início</th>
            <th scope="col">Hora de fim</th>
            <th scope="col">Data de criação</th>
            <th scope="col">Data de edição</th>
            <th scope="col"><a href="{{ url('hour-blocks/create') }}" class="btn btn-primary">Criar novo bloco</a></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hourBlocks as $hourBlock)
        <tr>
            <td>{{ $hourBlock->id }}</td>
            <td>{{ $hourBlock->hour_beginning }}</td>
            <td>{{ $hourBlock->hour_end }}</td>
            <td>{{ $hourBlock->created_at }}</td>
            <td>{{ $hourBlock->updated_at }}</td>
            <td>
                <a href="{{ url('hour-blocks/' . $hourBlock->id) }}" type="button" class="btn btn-primary">Detalhes</a>
                <a href="{{ url('hour-blocks/' . $hourBlock->id . '/edit') }}" type="button" class="btn btn-primary">Editar</a>
                <form action="{{ url('hour-blocks/' . $hourBlock->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Apagar bloco</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>