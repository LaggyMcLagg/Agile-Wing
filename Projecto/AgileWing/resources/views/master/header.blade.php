@auth

<div class="container">
    <div class="row">
        <div class="justify-content-end d-flex">
            <!-- tudo o que estivesse dentro deste auth apenas seria mostrado
            se o user tivesse um login valido, nao sendo necessário pois
            esta blade apenas é acedida pelo middleware auth garantindo a
            autenticação-->
            <!-- @auth -->
            <div class="d-flex align-items-center">
                    <span class="mr-2">Welcome, {{ auth()->user()->name }}!</span>
                    <span class="mr-2">ID: {{ auth()->user()->id }}</span>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-link nav-link" type="submit">Logout</button>
                    </form>
                </div>
            <!-- @endauth -->
        </div>
    </div>
</div>
@if(auth()->user()->user_type_id == 1)
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Agile Wing</a>
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
                    <!-- ADD THE ROUTES HERE -->
                </div>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Gestão Horários
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="{{ route('course-class-schedule-attribution.index')}}">Turma</a>
                    <a class="dropdown-item" href="{{url('/ROTA2/ROUTE2')}}">ROUTE2</a>
                    <!-- ADD THE ROUTES HERE -->
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Geral
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                    <a class="dropdown-item" href="{{ route('courses.index') }}">Gerir Crusos</a>
                    <a class="dropdown-item" href="{{ route('hour-blocks.index') }}">Gerir Blocos Horário</a>
                    <a class="dropdown-item" href="{{ url('/availability_types') }}">Tipo de disponibilidades</a>
                    <a class="dropdown-item" href="{{ route('course-classes.index')}}">Turma</a>
                    <a class="dropdown-item" href="{{ route('hour-block-course-classes.index')}}">Turma blocos horário</a>

                    <!-- ADD THE ROUTES HERE -->
                </div>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Preencher Disponibilidade
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route('teacher-availabilities.index') }}">Gerir Disponibilidade</a>
                    <a class="dropdown-item" href="{{url('/ROTA1/ROUTE2')}}">ROUTE2</a>
                    <!-- ADD THE ROUTES HERE -->
                </div>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Consultar Horários
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{url('/ROTA1/ROUTE1')}}">ROUTE1</a>
                    <a class="dropdown-item" href="{{url('/ROTA1/ROUTE2')}}">ROUTE2</a>
                    <!-- ADD THE ROUTES HERE -->
                </div>
            </li>
            <li class="">
                <a class="nav-link" href="{{route('users.passwordForm')}}" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                    Alterar Palavra-passe
                </a>
            </li>
        </ul>
    </div>
</nav>

@elseif(auth()->user()->user_type_id == 2)


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Agile Wing</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Preencher Disponibilidade
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route ('teacher-availabilities.index') }}">Disponibilidade do Formador</a>
                </div>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Consultar Horários Horários
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="{{ route('hour-block-course-classes.index')}}">Turma</a>
                    <!-- ADD THE ROUTES HERE -->
                </div>
            </li>
        
            <li class="">
                <a class="nav-link" href="{{route('users.passwordForm')}}" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                    Alterar Palavra-passe
                </a>
            </li>
        </ul>
    </div>
</nav>
@endif
@endauth