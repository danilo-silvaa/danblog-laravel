<nav class="site-nav border-bottom">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">

                <div class="d-flex bd-highlight g-0 align-items-center">
                    <div class="p-2 flex-grow-1 bd-highlight">
                        <a href="/" class="logo m-0 float-start">DanBlog<span class="text-primary">.</span></a>
                    </div>

                    <div id="search-form-relative" class="p-2 bd-highlight">
                        <form action="{{ route('posts.search') }}" method="GET" class="search-form d-lg-inline-block" autocomplete="off">
                            <input type="text" class="form-control" name="q" placeholder="Buscar" />
                            <span class="bi-search"></span>
                        </form>
                    </div>

                    <div class="p-2 bd-highlight">
                        @auth
                            <div class="dropdown">
                                 <div class="rounded-full author-figure-nav" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img class="rounded-full" src="{{ getUserAvatar(Auth::user()) }}" alt="{{Auth::user()->first_name}} {{Auth::user()->last_name}}">
                                 </div>

                                <ul class="dropdown-menu mt-4" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ route('account.profile') }}">Minha conta</a></li>
                                    <li><a class="dropdown-item" href="{{ route('account.logout') }}">Sair da conta</a></li>
                                </ul>
                            </div>
                        @else
                            <a href="/login" class="button-account">
                                <i class="bi-person me-1"></i>
                                Entre
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>