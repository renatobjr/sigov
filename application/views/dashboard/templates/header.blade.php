<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

        <!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ base_url('resources/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ base_url('resources/css/font-awesome.css') }}">
    {{-- JS --}}
    <script src="{{ base_url('resources/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ base_url('resources/js/bootstrap.min.js') }}"></script>
    {{-- Verificação de acesso --}}
    @if(!isset($_SESSION['isLogged']))
        {{ $_SESSION['erroAutorizacao'] = 'Você precisa inserir suas credenciais para ter acesso ao SIGov.' }}
        {{ redirect('login') }}
    @endif
</head>
{{-- Corpo da Aplicação --}}
<body>
{{-- Header contendo o menu principal da aplicação --}}
<header>
    <nav class="navbar navbar-inverse bg-danger">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ base_url('dashboard') }}"><img src="{{ base_url('resources/assets/sigov.bar.svg') }}" alt="Sigov" height="50em" style="margin-top: -0.6em;"></a>
            </div>
            {{-- Itens do navbar --}}
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                {{-- Menu do cadastramento de usuarios e dados da pesquisa: disponivel somente para o Administrador/gestor[1 - 2] --}}
                @if($_SESSION['perfil'] == 1)
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Equipe <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                @if($_SESSION['perfil'] == 1)
                                    <li><a href="#">Gestores</a></li>
                                @endif
                                <li><a href="#">PLi</a></li>
                                <li><a href="#">PS</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pesquisa <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Municípios</a></li>
                                <li><a href="#">Software</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
                {{-- Menu para Cadastro de municipios: disponivel somente para o PLI[3] --}}
                @if($_SESSION['perfil'] == 3)
                    <li><a href="#">Municípios</a></li>
                @endif
                {{-- Menu para Cadastro de software: disponivel somente para o PS[4] --}}
                @if($_SESSION['perfil'] == 3)
                    <li><a href="#">Software</a></li>
                @endif
                {{-- Menu do usuário --}}
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $_SESSION['nomeUsuario'] }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Perfil</a></li>
                            <li><a href="{{ base_url('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="container-fluid">
    @yield('main')
</main>
</body>
</html>