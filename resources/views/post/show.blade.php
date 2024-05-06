@extends('layouts.app')

@section('content')
<div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('{{asset('storage/' . $post->thumbnail)}}');">
    <div class="container">
        <div class="row same-height justify-content-center">
            <div class="col-md-6">
                <div class="post-entry text-center">
                    <h1 class="mb-4">{{$post->title}}</h1>
                    <div class="post-meta align-items-center text-center">
                        <figure class="author-figure mb-0 me-3 d-inline-block">
                            <img src="{{ getUserAvatar($post->user) }}" alt="Image" class="img-fluid" />
                        </figure>
                        <span class="d-inline-block mt-1">{{$post->user->first_name}} {{$post->user->last_name}}</span>
                        <span>&nbsp;-&nbsp; {{ \Carbon\Carbon::parse($post->created_at)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        
        @if (Auth::check() && Auth::user()->id === $post->user->id)
            <div class="d-flex justify-content-end mb-5">
                <button class="button-account me-3" data-bs-toggle="modal" data-bs-target="#editPostModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                    Editar
                </button>
                <button class="button-account bg-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                    Excluir
                </button>
            </div>
        @endif    

        <div class="row blog-entries element-animate">
            <div class="main-content mb-5">
                <div class="post-content-body">
                    <p class="text-prewrap">{{$post->content}}</p>
                </div>

                <div class="pt-5 comment-wrap">
                    @php
                        $commentTotal = $comments->total();
                    @endphp
                    <h3 class="mb-5 heading">{{ $commentTotal }} {{ $commentTotal == 1 ? 'Comentário' : 'Comentários' }}</h3>
                    
                    <div class="comment-form-wrap mb-5">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('comments.store', ['post' => $post->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <textarea name="comment" cols="30" rows="4" class="form-control" placeholder="Escreva um comentário..."></textarea>
                            </div>
                            <div class="form-group text-end">
                                <input type="submit" value="Postar comentário" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>

                    <ul class="comment-list">
                        @foreach ($comments as $comment)
                            <li class="comment">
                                <div class="vcard">
                                    <img src="{{getUserAvatar($comment->user)}}" alt="Image placeholder" />
                                </div>
                                <div class="comment-body">
                                    <h3>{{$comment->user->first_name}} {{$comment->user->last_name}}</h3>
                                    <div class="meta">{{ \Carbon\Carbon::parse($comment->created_at)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY [às] h:mma') }}</div>
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    @if ($comments->hasMorePages())
                        <div class="text-center">
                            <button class="btn-show-more mt-1 mb-4" data-post-id="{{ $post->id }}">Ver mais comentários</button>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="editPostModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-slate-100" id="exampleModalLabel">Editar postagem</h5>
                <button type="button" class="btn-close rounded-full" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="title">Título <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Qual o título do seu conteúdo?" value="{{$post->title}}" required></input>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="thumbnail">Miniatura <span class="text-danger">*</span></label>
                        <input type="file" id="thumbnail" name="thumbnail" class="form-control h-0"></input>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="content">Conteúdo <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" cols="30" rows="4" class="form-control" placeholder="Sobre o que você quer falar?" required>{{$post->content}}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePostModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-slate-100" id="exampleModalLabel">Excluir post</h5>
                <button type="button" class="btn-close rounded-full" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Você tem certeza de que deseja excluir este post? Esta ação não pode ser desfeita.</div>
            <div class="modal-footer border-0">
                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir post</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/pt-br.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('js/comments.js') }}"></script>
@endsection
@endsection