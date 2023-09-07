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


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{url('/ROTA1')}}">Agile Wing</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="{{url('/ROTA1')}}navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="dropdown">
            <a class="dropdown-toggle dropdown-style {{ Request::is('ROTA1*') ? 'active' : '' }}" role="button" data-toggle="dropdown" aria-expanded="false">
                Gestão Formadores
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Inserir Formador</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Editar Formador</a>
            </div>
        </div>

        <div class="dropdown">
            <a class="dropdown-toggle dropdown-style {{ Request::is('ROTA1*') ? 'active' : '' }}" role="button" data-toggle="dropdown" aria-expanded="false">
                Gestão Horários
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Formador</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Turma</a>
            </div>
        </div>

        <div class="dropdown">
            <a class="dropdown-toggle dropdown-style  {{ Request::is('ROTA1*') ? 'active' : '' }}" role="button" data-toggle="dropdown" aria-expanded="false">
                Geral
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Cursos</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Turmas</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Turmas</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Areas de Formaçãp</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Grupos Pedagógicos</a>
                <a class="dropdown-item" href="{{url('/ROTA1')}}">Blocos Horas do Formador</a>
            </div>
        </div>

        <form class="form-inline my-2 my-lg-0">
            <x-button class="btn-light-blue logout" modal-id="">Logout</x-button>
        </form>
    </div>
</nav>