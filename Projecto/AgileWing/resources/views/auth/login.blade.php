@extends('master.main')
@section('content')
<div class="login-container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <img class="bg-atec" src="{{ asset('images/bg-atec.png') }}" alt="bg-atec">
        </div>

        <div class="col-md-4 login-form">
            <h3>Login</h3>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf


                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Palavra-Passe">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="offset-md-3">
                            <button type="submit" class="btn btn-blue">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection