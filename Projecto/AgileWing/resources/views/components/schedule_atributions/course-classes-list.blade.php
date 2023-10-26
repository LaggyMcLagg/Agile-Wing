@section('scripts')
<script src="{{ asset('/js/search-table-function.js') }}"></script>
<script src="{{ asset('/js/sort-table-function.js') }}"></script>
<script>
    sessionStorage.setItem('baseUrl', '{{ route('schedule-atribution.store') }}');
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                const courseClassId = row.getAttribute('data-id');
                const baseUrl = sessionStorage.getItem('baseUrl');
                window.location.href = `${baseUrl}/${courseClassId}`;
            });
        });
    });
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
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form class="form-inline my-2 my-lg-0 justify-content-end">
                <input id="search-input" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Pesquisa</button>
            </form>
        </div>
    </div>
</div>

<h3>Listagem de Turmas para gestão de atribuições</h3>

<table class="table table-bordered" id="sortable-table">
    <thead>
        <tr>
            <th data-column-index="0" scope="col">Turma</th>
            <th data-column-index="1" scope="col">Curso</th>
            <th data-column-index="2" scope="col">Area Formação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courseClasses as $courseClass)
        <tr class="clickable-row" data-id="{{ $courseClass->id }}">
            <td>{{ $courseClass->name }} - {{ $courseClass->number }} </td>
            <td>{{ $courseClass->course->name }}</td>
            <td>{{ $courseClass->course->specializationArea->number }} - {{ $courseClass->course->specializationArea->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
