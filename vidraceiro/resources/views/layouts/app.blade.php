<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

{{--<!-- Scripts -->--}}
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}

{{--<!-- Fonts -->--}}
{{--<link rel="dns-prefetch" href="https://fonts.gstatic.com">--}}
{{--<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">--}}

<!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
          integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 nomp-flex">
            <div id="menu-dashboard" class="sidebar">
                <div class="logo">
                    <a href="{{ route('home') }}" class="simple-text">
                        {{ config('app.name', 'Vidraceiro') }}
                    </a>
                </div>
                <ul class="nav">
                    <li {{ Request::is('home') ? 'class=active' : '' }}>
                        <a href="{{route('home')}}">
                            <i class="pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li {{ Request::is('users') ? 'class=active' : '' }}>
                        <a href="{{ route('users.index') }}">
                            <i class="pe-7s-user"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                    <li {{ Request::is('') ? 'class=active' : '' }}>
                        <a href="table.html">
                            <i class="pe-7s-note2"></i>
                            <p>Categorias</p>
                        </a>
                    </li>
                    <li {{ Request::is('product') ? 'class=active' : '' }}>
                        <a href="{{ route('product.index') }}">
                            <i class="pe-7s-news-paper"></i>
                            <p>Produtos</p>
                        </a>
                    </li>
                    <li {{ Request::is('') ? 'class=active' : '' }}>
                        <a href="icons.html">
                            <i class="pe-7s-science"></i>
                            <p>Materiais</p>
                        </a>
                    </li>
                    <li {{ Request::is('') ? 'class=active' : '' }}>
                        <a href="maps.html">
                            <i class="pe-7s-map-marker"></i>
                            <p>Orçamentos</p>
                        </a>
                    </li>
                    <li {{ Request::is('') ? 'class=active' : '' }}>
                        <a href="notifications.html">
                            <i class="pe-7s-bell"></i>
                            <p>Ordens de serviço</p>
                        </a>
                    </li>
                    <li {{ Request::is('') ? 'class=active' : '' }}>
                        <a href="upgrade.html">
                            <i class="pe-7s-rocket"></i>
                            <p>Fornecedores</p>
                        </a>
                    </li>
                    <li {{ Request::is('') ? 'class=active' : '' }}>
                        <a href="upgrade.html">
                            <i class="pe-7s-rocket"></i>
                            <p>Empresa</p>
                        </a>
                    </li>
                    <li class="">
                        <i class="pe-7s-rocket"></i>
                        <div class="borda-top"></div>
                            <a href="{{ route('home') }}">
                                <p>{{ Auth::user()->name }}</p>
                            </a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-nav').submit();">
                                <p>{{ __('Logout') }}</p>
                            </a>
                        <form id="logout-nav" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>

                    </li>
                </ul>
            </div>

            <div class="main-panel">
                <nav class="navbar navbar-expand-md navbar-light bg-light navbar-shadow">
                    <a class="navbar-brand" href="{{ Request::url() }}">{{ $title }}</a>
                    <div class="collapse navbar-collapse" id="navbarsExample0233">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle minhaconta" href="https://example.com"
                                   id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <p>{{ Auth::user()->name }}</p>
                                    <small class="admin">Admin</small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="#">Action</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#"
                            aria-controls="#" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </nav>
                <section id="painel">
                    @yield('content')
                </section>

                <footer class="shadow-top">
                    <p>© 2018 Vidraceiro.</p>
                </footer>
            </div>


        </div>
    </div>
</div>


<script src="{{ asset('js/jquery.min.js') }}" defer></script>
<script src="{{ asset('js/popper.js') }}" defer></script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}" defer></script>
<script src="{{ asset('js/dashboard.js') }}" defer></script>

@yield('scripts')
</body>
</html>
