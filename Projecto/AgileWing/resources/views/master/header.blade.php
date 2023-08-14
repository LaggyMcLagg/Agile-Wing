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
                <a class="nav-link" href="{{url('/ROTA1')}}">METER AQUI NOME</a>
            </li>
            <li class="nav-item {{ Request::is('ROTA2*') ? 'active' : '' }}">
                <a class="nav-link" href="{{url('/ROTA2')}}">METER AQUI NOME</a>
            </li>
            <li class="nav-item {{ Request::is('ROTA3*') ? 'active' : '' }}">
                <a class="nav-link" href="{{url('/ROTA3')}}">METER AQUI NOME</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
