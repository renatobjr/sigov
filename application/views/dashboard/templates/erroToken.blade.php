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
            </div>
            <div class="panel-body">
                <h6 class="lead text-center">Não foi possível finalizar seu cadastro!</h6>
                <p class="lead text-center">Entre em contato com o Administrador do Sistema para verificar o que aconteceu!</p>
            </div>
        </div>
    </div>
</main>
</body>
</html>
