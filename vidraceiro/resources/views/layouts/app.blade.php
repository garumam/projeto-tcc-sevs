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
    <link href="{{ asset('css/component-chosen.min.css') }}" rel="stylesheet">
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
                            Dashboard
                        </a>
                    </li>
                    <li {{ Request::is('clients') ? 'class=active' : '' }}>
                        <a href="{{ route('clients.index') }}">
                            <i class="pe-7s-map-marker"></i>
                            Clientes
                        </a>
                    </li>
                    <li {{ Request::is('budgets') ? 'class=active' : '' }}>
                        <a href="{{ route('budgets.index') }}">
                            <i class="pe-7s-map-marker"></i>
                            Orçamentos
                        </a>
                    </li>
                    <li {{ Request::is('sales') ? 'class=active' : '' }}>
                        <a href="{{ route('sales.index') }}">
                            <i class="pe-7s-rocket"></i>
                            Vendas
                        </a>
                    </li>
                    <li {{ Request::is('orders') ? 'class=active' : '' }}>
                        <a href="{{ route('orders.index') }}">
                            <i class="pe-7s-bell"></i>
                            Ordens de serviço
                        </a>
                    </li>
                    <li class="opensubmenu">
                        <a>
                            <i class="pe-7s-news-paper"></i>
                            Modelos<i class="fas fa-angle-down float-right m-1" style="font-size: 1.3rem;"></i>
                        </a>
                        <ul class="submenu">
                            <li {{ Request::is('products') ? 'class=active' : '' }}>
                                <a href="{{ route('mproducts.index') }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Produtos
                                </a>
                            </li>
                            <li {{ Request::is('materials') ? 'class=active' : '' }}>
                                <a href="{{ route('materials.index') }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Materiais
                                </a>
                            </li>
                            <li {{ Request::is('categories') ? 'class=active' : '' }}>
                                <a href="{{ route('categories.index') }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Categorias
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li {{ Request::is('storage') ? 'class=active' : '' }}>
                        <a href="{{ route('storage.index') }}">
                            <i class="pe-7s-bell"></i>
                            Estoque
                        </a>
                    </li>
                    <li {{ Request::is('financial') ? 'class=active' : '' }}>
                        <a href="{{ route('financial.index') }}">
                            <i class="pe-7s-bell"></i>
                            Financeiro
                        </a>
                    </li>
                    {{--<li {{ Request::is('categories') ? 'class=active' : '' }}>--}}
                    {{--<a href="{{ route('categories.index') }}">--}}
                    {{--<i class="pe-7s-note2"></i>--}}
                    {{--Categorias--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li {{ Request::is('materials') ? 'class=active' : '' }}>--}}
                    {{--<a href="{{ route('materials.index') }}">--}}
                    {{--<i class="pe-7s-science"></i>--}}
                    {{--Materiais--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    <li class="opensubmenu">
                        <a>
                            <i class="pe-7s-user"></i>
                            Usuarios<i class="fas fa-angle-down float-right m-1" style="font-size: 1.3rem;"></i>
                        </a>
                        <ul class="submenu">
                            <li {{ Request::is('users') ? 'class=active' : '' }}>
                                <a href="{{ route('users.index') }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Usuarios
                                </a>
                            </li>
                            <li {{ Request::is('roles') ? 'class=active' : '' }}>
                                <a href="{{ route('roles.index') }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Funções
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li {{ Request::is('providers') ? 'class=active' : '' }}>
                        <a href="{{ route('providers.index') }}">
                            <i class="pe-7s-rocket"></i>
                            Fornecedores
                        </a>
                    </li>
                    <li {{ Request::is('companies') ? 'class=active' : '' }}>
                        <a href="{{ route('companies.index') }}">
                            <i class="pe-7s-rocket"></i>
                            Empresa
                        </a>
                    </li>
                    {{--<li {{ Request::is('pdf') ? 'class=active' : '' }}>
                        <a href="{{ route('pdf.index') }}">
                            <i class="pe-7s-rocket"></i>
                            Relatórios
                        </a>
                    </li>--}}
                    <li class="opensubmenu">
                        <a>
                            <i class="pe-7s-news-paper"></i>
                            Relatórios<i class="fas fa-angle-down float-right m-1" style="font-size: 1.3rem;"></i>
                        </a>
                        <ul class="submenu">
                            <li {{ Request::is('pdf/budgets') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'budgets'])}}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Orçamentos
                                </a>
                            </li>
                            <li {{ Request::is('pdf/orders') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'orders']) }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Ordens de serviço
                                </a>
                            </li>
                            <li {{ Request::is('pdf/storage') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'storage']) }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Estoque
                                </a>
                            </li>
                            <li {{ Request::is('pdf/financial') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'financial']) }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Financeiro
                                </a>
                            </li>
                            <li {{ Request::is('pdf/clients') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'clients']) }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Clientes
                                </a>
                            </li>
                            <li {{ Request::is('pdf/providers') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'providers']) }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Fornecedores
                                </a>
                            </li>
                            <li {{ Request::is('pdf/sales') ? 'class=active' : '' }}>
                                <a href="{{ route('pdf.index',['tipo'=>'sales']) }}">
                                    <i class="fas fa-angle-double-right pr-1"></i>Vendas
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li {{ Request::is('restore') ? 'class=active' : '' }}>
                        <a href="{{ route('restore.index') }}">
                            <i class="pe-7s-rocket"></i>
                            Restaurar
                        </a>
                    </li>
                    <li>
                        <i class="pe-7s-rocket"></i>
                        <div class="borda-top"></div>
                        <a href="{{ route('home') }}">
                            {{ Auth::user()->name }}
                        </a>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-nav').submit();">
                            {{ __('Logout') }}
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
                            <img src="{{ asset(Auth::user()->image ?? 'img/semimagem.png') }}"
                                 class="imagem-usuario rounded-circle">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle minhaconta" href="https://example.com"
                                   id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <p>{{ Auth::user()->name }}</p>
                                    <small class="badge badge-primary admin">{{ Auth::user()->getRole()->nome ?? '' }}</small>
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
                                    {{--<a class="dropdown-item" href="#">Action</a>--}}
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

                {{--<footer class="shadow-top">--}}
                {{--<p>© 2018 Vidraceiro.</p>--}}
                {{--</footer>--}}
            </div>


        </div>
    </div>
</div>


<!-- Modal Alerta-->
<a id="bt-alert-modal" href="#" class="" data-toggle="modal" data-target="#alertaModal"></a>
<div class="modal fade" id="alertaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p id="alertaMensagem" class="text-dark"> ae</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Ok</button>
            </div>

        </div>
    </div>
</div>


<form id="delete-form" action="#" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>

<form id="update-form" action="#" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" value="PATCH">
</form>

{{--<script src="{{ asset('js/jquery.min.js') }}" defer></script>--}}

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/popper.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js" type="text/javascript"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deletar(e, id, nome) {
        if (id != 'vazio') {
            var form = document.getElementById('delete-form');
            form.action = "/" + nome + "/" + id;
            e.preventDefault();
            form.submit();
        }
    }

    function atualizar(e, id, situacao) {
        if (id != 'vazio') {
            var form = document.getElementById('update-form');
            form.action = "/orders/" + id + "/" + situacao;
            e.preventDefault();
            form.submit();
        }
    }
    var meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    graficoVendas();
    graficofinanceiro();
    graficoOrdens();

    function graficoVendas(){
        var ctxVendas = document.getElementById("vendas");
        fetch('http://127.0.0.1:8000/api/dashboard/sales')
            .then(result => result.json())
            .then((data) => {
                var graficoVendas = new Chart(ctxVendas, {
                    type: "line",
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Qtd Vendas',
                            data: data,
                            backgroundColor: 'rgba(51,153,255,0.5)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                });
            });
    }


    function graficofinanceiro() {
        var ctxFinanceiro = document.getElementById("financeiro");
        fetch('http://127.0.0.1:8000/api/dashboard/financial')
            .then(response => response.json())
            .then((data) => {
                console.log(data);
                var graficoFinanceiro = new Chart(ctxFinanceiro, {
                    type: "line",
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Receitas',
                            data: data.receitas,
                            backgroundColor: 'rgba(51,153,255,0.5)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Despesas',
                                data: data.despesas,
                                backgroundColor: 'rgba(255,0,0,0.5)',
                                borderColor: 'rgba(255,0,0,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                    }
                });
        });

    }

    function graficoOrdens() {
        var ctxOrdens = document.getElementById("ordensgraph");
        fetch('http://127.0.0.1:8000/api/dashboard/orders')
            .then(response => response.json())
            .then((data) => {
                var graficoOrdens = new Chart(ctxOrdens, {
                    type: "bar",
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Concluídas',
                            data: data.concluidas,
                            backgroundColor: 'rgba(51,153,255,0.5)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Canceladas',
                                data: data.canceladas,
                                backgroundColor: 'rgba(255,0,0,0.5)',
                                borderColor: 'rgba(255,0,0,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                    }
                });
            });

    }


    var ctxClientes = document.getElementById("clientes");
    var ctxOrcamentos = document.getElementById("orcamentosgraph");




    var graficoClientes = new Chart(ctxClientes, {
        type: "pie",
        data: {
            datasets: [{
                data: [10,20],
                backgroundColor: ['rgba(51,153,255,0.5)','rgba(255,0,0,0.5)'],
                borderColor: ['rgba(51,153,255,1)','rgba(255,0,0,1)'],
                borderWidth: 2
            }
            ],

            labels: [
                'Em dia',
                'Devendo'
            ]

        },
        options: {
            responsive: true,
        }
    });

    var graficoOrcamentos = new Chart(ctxOrcamentos, {
        type: "bar",
        data: {
            labels: meses,
            datasets: [{
                label: 'Aprovados',
                data: [1, 3, 5, 8, 9, 100],
                backgroundColor: 'rgba(100,255,50,0.5)',
                borderColor: 'rgba(100,255,50,1)',
                borderWidth: 2
            },
                {
                    label: 'Finalizados',
                    data: [20, 25, 30, 50, 200, 300],
                    backgroundColor: 'rgba(51,153,255,0.5)',
                    borderColor: 'rgba(51,153,255,1)',
                    borderWidth: 2
                }

            ]
        },
        options: {
            responsive: true,
        }
    });

</script>
</body>
</html>
