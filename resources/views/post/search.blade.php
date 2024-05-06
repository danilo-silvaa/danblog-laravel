@extends('layouts.app')

@section('content')

@include('includes.search_form')

<section class="section pt-0 mt-5">
    <div class="container search-result-wrap">
        @if (count($posts) > 0)
            <h3 class="heading text-uppercase">Resultados da busca por: "{{$searchTerm}}"</h3>

            <section class="section pt-0 posts-entry posts-entry-sm">
                <div class="row">
                    @foreach (count($posts) > 0 ? $posts : $latestPosts as $post)
                        @include('includes.post_card', ['post' => $post])
                    @endforeach
                </div>
            </section>
        @else
            <h3 class="heading text-uppercase">Nenhum resultado encontrado para: "{{$searchTerm}}"</h3>
            
            <section class="section pt-0 posts-entry posts-entry-sm">
                <div class="container">
                    <h3 class="text-uppercase mb-0">Postagens mais recentes:</h3>
                    <div class="row">
                        @foreach (count($posts) > 0 ? $posts : $latestPosts as $post)
                            @include('includes.post_card', ['post' => $post])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @include('includes.pagination', ['paginator' => $posts])
    </div>
</section>
@endsection