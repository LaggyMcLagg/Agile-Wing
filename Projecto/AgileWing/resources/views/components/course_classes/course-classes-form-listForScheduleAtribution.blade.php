<style>
  table {
    max-width: 1000px;
    max-height: 600px;
    margin: 0 auto;
    border-collapse: collapse;
  }

  th, td {
    padding: 8px 12px;
    text-align: left;
  }

  tr:nth-child(even) {
    background-color: #87CEFA;
  }

  tr:hover {
    background-color: #ccc;
  }

  select {
    width: 100%;
  }
</style>
</head>
<body>

<table class="table">
    <thead>
        <tr>
            <th scope="col">
                <select id="turmaDropdown">
                    <option value="">Turma</option>
                </select>
            </th>
            <th scope="col">
                <select id="areaFormacaoDropdown">
                    <option value="">Área Formação</option>
                </select>
            </th>
        </tr>
    </thead>
    <tbody id="tableBody">
        @foreach($courseClasses as $courseClass)
        <tr data-link="{{ route('course-class.schedule-attribution.show', ['courseClass' => $courseClass]) }}">
            <td>{{ $courseClass->name }} - {{ $courseClass->number }}</td>
            <td>{{ $courseClass->course->specializationArea->number }} - {{ $courseClass->course->specializationArea->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('tbody tr');
        const turmaDropdown = document.getElementById('turmaDropdown');
        const areaFormacaoDropdown = document.getElementById('areaFormacaoDropdown');
        const tableBody = document.getElementById('tableBody');

        const turmaOptions = new Set();
        const areaFormacaoOptions = new Set();

        tableRows.forEach(row => {
            const turmaCell = row.querySelector('td:first-child').textContent;
            const areaFormacaoCell = row.querySelector('td:nth-child(2)').textContent;

            turmaOptions.add(turmaCell);
            areaFormacaoOptions.add(areaFormacaoCell);

            row.addEventListener('click', function () {
                const link = row.getAttribute('data-link');
                window.location.href = link;
            });
        });

        // Preencher os dropdowns com as opções
        turmaOptions.forEach(option => {
            const turmaOption = document.createElement('option');
            turmaOption.value = option;
            turmaOption.textContent = option;
            turmaDropdown.appendChild(turmaOption);
        });

        areaFormacaoOptions.forEach(option => {
            const areaFormacaoOption = document.createElement('option');
            areaFormacaoOption.value = option;
            areaFormacaoOption.textContent = option;
            areaFormacaoDropdown.appendChild(areaFormacaoOption);
        });

        // exibe apenas com a seleção dos dropdowns
        turmaDropdown.addEventListener('change', updateTable);
        areaFormacaoDropdown.addEventListener('change', updateTable);

        function updateTable() {
            const selectedTurma = turmaDropdown.value;
            const selectedAreaFormacao = areaFormacaoDropdown.value;

            tableRows.forEach(row => {
                const turmaCell = row.querySelector('td:first-child').textContent;
                const areaFormacaoCell = row.querySelector('td:nth-child(2)').textContent;

                if ((selectedTurma === '' || turmaCell === selectedTurma) &&
                    (selectedAreaFormacao === '' || areaFormacaoCell === selectedAreaFormacao)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    });
</script>
