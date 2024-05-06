@extends('layouts.app')

@section('content')

<main class="main mt-5">
    <div class="container">
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="g-3 row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 text-slate-100">Dados pessoais</h5>
                        </div>
                        <div class="bg-body-tertiary card-body">
                            <form action="{{ route('account.update') }}" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 g-3 row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="first_name">Primeiro nome</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $user->first_name }}" placeholder="Primeiro Nome" required>
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label" for="last_name">Sobrenome</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $user->last_name }}" placeholder="Sobrenome" required>
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">E-mail</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" placeholder="Seu e-mail" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-6">
                    <div class="sticky-sidebar">
                        <div class="mb-3 card">
                            <div class="card-header">
                                <h5 class="mb-0 text-slate-100">Alterar foto</h5>
                            </div>
                            <form action="{{ route('account.avatar.update') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="bg-body-tertiary card-body">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="avatar" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url({{ getUserAvatar($user) }});">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-100 btn btn-primary">Confirmar alteração</button>
                                </div>
                            </form>
                        </div>
                        <div class="mb-3 card">
                            <div class="card-header">
                                <h5 class="mb-0 text-slate-100">Alteração de senha</h5>
                            </div>
                            <div class="bg-body-tertiary card-body">
                                <form action="{{ route('account.change.password') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="current_password">Senha atual</label>
                                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Senha atual" required>
                                        @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="new_password">Nova senha</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nova senha" required>
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="w-100 btn btn-primary">Alterar</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-slate-100">Excluir conta</h5>
                            </div>
                            <div class="bg-body-tertiary card-body">
                                <p class="fs-10 mb-3">Ao excluir sua conta, todos os seus dados serão permanentemente apagados.</p>
                                <button type="button" class="w-100 btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Excluir minha conta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="deleteAccountModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-slate-100" id="exampleModalLabel">Excluir sua conta</h5>
                <button type="button" class="btn-close rounded-full" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Você tem certeza de que deseja excluir sua conta? Esta ação não pode ser desfeita.</div>
            <div class="modal-footer border-0">
                <form action="{{ route('account.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir Conta</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('js/imagePreview.js') }}"></script>
@endsection

@endsection
