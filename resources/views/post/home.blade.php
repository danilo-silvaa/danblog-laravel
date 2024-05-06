@extends('layouts.app')

@section('content')

@include('includes.search_form')

<section class="section pt-0 mt-5">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @auth
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="posts-entry-title">Olá, {{ auth()->user()->first_name }}</h1>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <button class="button-account" data-bs-toggle="modal" data-bs-target="#createPostModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm7.5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zM2 5.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5M10.5 5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM13 8h-2V6h2z"/>
                        </svg>
                        Fazer postagem
                    </button>
                </div>
            </div>
        @endauth
        <div class="row">
            @foreach ($posts as $post)
                @include('includes.post_card', ['post' => $post])
            @endforeach
        </div>

        @include('includes.pagination', ['paginator' => $posts])
    </div>
</section>


<div class="modal fade" id="createPostModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-slate-100" id="exampleModalLabel">Escrever postagem</h5>
                <button type="button" class="btn-close rounded-full" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('posts.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="title">Título <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Qual o título do seu conteúdo?" required></input>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="thumbnail">Miniatura <span class="text-danger">*</span></label>
                        <input type="file" id="thumbnail" name="thumbnail" class="form-control h-0" required></input>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="content">Conteúdo <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" cols="30" rows="4" class="form-control" placeholder="Sobre o que você quer falar?" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection