<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="pt-br">
{{-- Cabeçalho da aplicaçao --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ base_url('resources/css/bootstrap.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ base_url('resources/assets/sigov.png') }}">
    <style>
        body{
            padding-top: 8em;
        }
    </style>
    {{-- JS --}}
    <script src="{{ base_url('resources/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ base_url('resources/js/bootstrap.min.js') }}"></script>
</head>
{{-- Corpo da aplicação --}}
<body>
    {{-- Container principal - Requisito básico/Obrigatório --}}
    <main class="container">
        {{-- Div para o painel principal de login --}}
        <div class="col-lg-4 col-lg-offset-4">
            {{-- Construção do painel --}}
            <div class="panel panel-default">
                {{-- Logo --}}
                <div class="panel-heading"><img class="center-block" src="{{ base_url('resources/assets/sigov.svg') }}" alt="sigov" width="30%"></div>
                <ul class="list-group">
                    {{-- Inicio do formulário de login --}}
                    {!! form_open('login') !!}
                        <li class="list-group-item">
                            <div class="form-group">
                                <label for="emailUsuario" class="control-label">Login</label>
                                <input type="text" name="emailUsuario" value="{{ set_value('emailUsuario') }}" class="form-control" placeholder="Informe seu e-mail de acesso">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Senha</label>
                                <input type="password" name="password" class="form-control" placeholder="Informe sua senha">
                                <p class="text-center"><a href="{{ base_url('redefinir-senha') }}">Esqueci minha senha!</a></p>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <button type="submit" class="center-block btn btn-primary btn-sx">Acessar</button>
                        </li>
                    {!! form_close() !!}
                </ul>
            </div>
        </div>
        {{-- Div para as mensagens de erro --}}
        <div class="col-lg-3">
            {{-- Mensagem de erro para o formulário padrão --}}
            {!! validation_errors(
                '<div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Ops! </strong>Verifique se está tudo certo e tente novamente.<br> ',
                '</div>'
            ) !!}
            {{-- Mensagem de sucesso para cadastro da senha --}}
            @if(isset($_SESSION['sucessoCadastraSenha']))
                <div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Perfeito! </strong><br><p>{{ $_SESSION['sucessoCadastraSenha'] }}</p>
                </div>
            @endif{{-- Mensagem de erro para falha durante autenticação --}}
            @if(isset($_SESSION['loginErro']))
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Ops! </strong><br><p>{{ $_SESSION['loginErro'] }}</p>
                </div>
            @endif
            {{-- Mensagem de erro para falha de autenticação  --}}
            @if(isset($_SESSION['erroAutorizacao']))
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Ops! </strong><br><p>{{ $_SESSION['erroAutorizacao'] }}</p>
                </div>
                {!! session_unset($_SESSION['erroAutorizacao']) !!}
            @endif
            @if(isset($_SESSION['sucessoRedefinirSenha']))
                <div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Ops! </strong><br><p>{{ $_SESSION['sucessoRedefinirSenha'] }}</p>
                </div>
                {!! session_unset($_SESSION['sucessoRedefinirSenha']) !!}
            @endif
        </div>
    </main>
</body>
</html>
