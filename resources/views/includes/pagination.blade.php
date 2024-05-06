@if ($paginator->previousPageUrl() || $paginator->nextPageUrl())
    <div class="row text-start pt-5 border-top">
        {{ $paginator->links('pagination::bootstrap-4') }}
    </div>
@endif