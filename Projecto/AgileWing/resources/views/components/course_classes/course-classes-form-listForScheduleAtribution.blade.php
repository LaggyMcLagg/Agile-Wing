<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Turma</th>
            <th scope="col">Curso</th>
            <th scope="col">Area Formação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courseClasses as $courseClass)
        <tr>
            <th scope="row">{{ $courseClass->id }}</th>
            <td>{{ $courseClass->name }} - {{ $courseClass->number }} </td>
            <td>{{ $courseClass->course->name }}</td>
            <td>{{ $courseClass->course->specializationArea->number }} - {{ $courseClass->course->specializationArea->name }}</td>
            <td>
                <form action="{{ route('schedule-atribution.index', ['courseClass' => $courseClass]) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Atribuições
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
