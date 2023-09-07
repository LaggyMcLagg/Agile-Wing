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
    <a class="navbar-brand" href="#">Agile Wing</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::is('ROTA1*') ? 'active' : '' }}">
                <a class="nav-link dropdown-style" href="{{url('/ROTA1')}}">Preencher Horários</a>
            </li>
            <li class="nav-item {{ Request::is('ROTA2*') ? 'active' : '' }}">
                <a class="nav-link dropdown-style " href="{{url('/ROTA2')}}">Consultar Horários</a>
            </li>
            <li class="nav-item {{ Request::is('ROTA3*') ? 'active' : '' }}">
                <a class="nav-link dropdown-style" href="{{url('/ROTA3')}}">Alterar Palavra-Passe</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <x-button class="btn-light-blue logout" modal-id="">Logout</x-button>
        </form>
    </div>
</nav>