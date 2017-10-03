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
    <style>
        body{
            padding-top: 6em;
        }
    </style>
    {{-- JS --}}
    <script src="{{ base_url('resources/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ base_url('resources/js/bootstrap.min.js') }}"></script>
</head>
<body>
{{-- Container principal - Requisito básico/Obrigatório --}}
<main class="container">
    {{-- Div para o painel principal de login --}}
    <div class="col-lg-4 col-lg-offset-4">
        {{-- Construção do painel --}}
        <div class="panel panel-default">
            {{-- Logo --}}
            <div class="panel-heading">
                <img class="center-block" src="{{ base_url('resources/assets/sigov.svg') }}" alt="sigov" width="30%">
                <h5 class="lead text-center">Redefinir senha</h5>
            </div>
            <ul class="list-group">
                {{-- Inicio do formulário de login --}}
                {!! form_open('atualizar-senha') !!}
                <li class="list-group-item">
                    <div class="form-group">
                        <label for="emailUsuario" class="control-label">Email</label>
                        <input type="email" name="emailUsuario" value="{{ set_value('emailUsuario') }}" class="form-control" placeholder="Digite seu email">
                    </div>
                    <div class="form-group">
                        <label for="confirmarEmail" class="control-label">Confirme a senha</label>
                        <input type="email" name="confirmarEmail" class="form-control" placeholder="Confirme seu email">
                    </div>
                </li>
                <li class="list-group-item">
                    <button type="submit" class="center-block btn btn-primary btn-sx">Solicitar</button>
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
        {{-- Mensagem de erro para erro durante autenticação --}}
        @if(isset($_SESSION['emailNaoEncontrado']))
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! </strong><br><p>{{ $_SESSION['emailNaoEncontrado'] }}</p>
        </div>
        @endif
    </div>
</main>
</body>
</html>
