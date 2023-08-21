@extends('master.main')

@section('content')

<h2>Informação do formador</h2>

<div class="card">
    <div class="card-body">
        <p class="card-text"><strong>ID:</strong> {{ $user->id }}</p>
        <p class="card-text"><strong>Nome:</strong> {{ $user->name }}</p>
        <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
    </div>
</div>

<h3>Grupos Pedagógicos</h3>
    <table class="table table-bordered" id="sortable-table">
        <thead>
            <tr>
                <th scope="col">Grupo Pedagógico</th>
                <th scope="col">Selected</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedagogicalGroups as $pedagogicalGroup)
                <tr>
                    <td>{{ $pedagogicalGroup->name }}</td>
                    <td>
                        <input type="checkbox" {{ $pedagogicalGroupUser[$pedagogicalGroup->name] ? 'checked' : '' }}>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

