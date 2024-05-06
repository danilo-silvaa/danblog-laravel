<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.head')
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-md-7 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 class="text-slate-100 fw-bold">Cadastre-se gratuitamente</h2>
                    </div>
                    <form class="mb-3" autocomplete="off">
                        <div class="mb-2">
                            <label class="form-label" for="first_name">Primeiro nome</label>
                            <input type="text" id="first_name" class="form-control form-control-lg bg-light fs-6" placeholder="Seu primeiro nome" />
                            <div id="firstNameError" class="error form-text text-danger mb-4 d-none"></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="last_name">Sobrenome</label>
                            <input type="text" id="last_name" class="form-control form-control-lg bg-light fs-6" placeholder="Seu Sobrenome" />
                            <div id="lastNameError" class="error form-text text-danger mb-4 d-none"></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="email">E-mail</label>
                            <input type="email" id="email" class="form-control form-control-lg bg-light fs-6" placeholder="Seu e-mail" />
                            <div id="emailError" class="error form-text text-danger mb-4 d-none"></div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="password">Senha</label>
                            <input type="password" id="password" class="form-control form-control-lg bg-light fs-6" placeholder="Deve ter no mínimo 7 caracteres" />
                            <div id="passwordError" class="error form-text text-danger mb-4 d-none"></div>
                        </div>
                        <div class="mb-2">
                            <button type="button" id="submitBtn" class="btn btn-lg btn-primary w-100 fw-bold pt-3 pb-3 fs-6">Cadastre-se gratuitamente</button>
                        </div>
                    </form>

                    <hr size class="mt-3 mb-3"/>

                    <div class="rounded p-3 mb-3" style="background: rgb(24 34 53); color: #fff">
                        Já possui uma conta? <a href="/login">Entre na plataforma</a>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/register.js') }}"></script>
</html>
