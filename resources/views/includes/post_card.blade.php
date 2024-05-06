<div class="col-lg-4 mb-4">
    <div class="post-entry-alt">
        <div class="img-link">
            <a href="/posts/{{ $post->slug }}" class="img-link">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Image" class="img-fluid">
            </a>
        </div>
        <h2><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h2>
        <div class="post-meta">
            <figure class="author-figure mb-0 me-2 d-inline-block align-middle">
                <img src="{{ getUserAvatar($post->user) }}" alt="Image" class="img-fluid rounded-circle">
            </figure>
            <div class="author-details d-inline-block align-middle">
                <span class="d-block"><a>{{ $post->user->first_name }} {{ $post->user->last_name }}</a></span>
                <span class="d-block">{{ \Carbon\Carbon::parse($post->created_at)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
            </div>
        </div>

        <p>{{ \Illuminate\Support\Str::limit($post->content ?? '', 194, '(...)') }}</p>
    </div>
</div>