<link rel="stylesheet" href="{{ asset('css/header.css') }}">

@auth

@if(auth()->user()->user_type_id == 1)
<nav class="navbar navbar-expand-lg navbar-light">
<a class="navbar-brand" href="{{ route ('home') }}"><img src="{{ asset('images/atec-logo.png') }}" alt="atec-logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestão Formadores
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route ('users.create') }}">Inserir Formador</a>
                    <a class="dropdown-item" href="{{route('users.edit')}}">Editar Formador</a>
                    <a class="dropdown-item" href="{{route('users.index')}}">Listar Formador</a>
                </div>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestão Horários
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="{{ route('course-class-schedule-attribution.index')}}">Turma</a>
                    <a class="dropdown-item" href="{{ route('users.index-teachers')}}">Formadores</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestão Geral
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                    <a class="dropdown-item" href="{{ route('courses.index') }}">Cursos</a>
                    <a class="dropdown-item" href="{{ route('course-classes.index')}}">Turma</a>
                    <a class="dropdown-item" href="{{ route('ufcds.index') }}">UFCDs</a>
                    <a class="dropdown-item" href="{{ route('specialization-areas.index') }}">Areas de formação</a>
                    <a class="dropdown-item" href="{{ route('pedagogical-groups.index') }}">Grupos Pedagógicos</a>
                    <a class="dropdown-item" href="{{ route('availability-types.index') }}">Tipo de disponibilidades</a>
                    <a class="dropdown-item" href="{{ route('hour-block-course-classes.index')}}">Blocos Horário (Turmas)</a>
                    <a class="dropdown-item" href="{{ route('hour-blocks.index') }}">Blocos Horário</a>
                    <a class="dropdown-item" href="{{ route('user-types.index') }}">Tipos de Utilizador</a>
                </div>
            </li>
            <li class="">
                <a class="nav-link" href="{{route('users.passwordForm')}}" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                    Alterar Palavra-passe
                </a>
            </li>
            
            <li class="containernav">
                        <span class="mr-2">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn logout" type="submit">Logout</button>
                        </form>
            </li>
        </ul>
    </div>
</nav>

@elseif(auth()->user()->user_type_id == 2)

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Agile Wing</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher-availabilities.index', ['id' => auth()->user()->id]) }}">
                    Preencher Disponibilidade
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.passwordForm')}}" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                    Alterar Palavra-passe
                </a>
            </li>
            <li class="containernav nav-item">
                <div class="justify-content-end d-flex">
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Bem-vindo(a), {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn nav-link" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
@endif
@endauth
