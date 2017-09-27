@extends('dashboard.templates.header')

@section('main')
    @if(isset($_SESSION['loginSucesso']))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>SIGov 1.0 </strong><br><p>{{ $_SESSION['loginSucesso'] }}</p>
        </div>
    @endif
    <div class="row">
        {{-- Últimos 20 municípios cadastrados --}}
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="lead">Municípios cadastrados</span>
                    <p class="lead pull-right"><i class="fa fa-map"></i></p>
                </div>
                <table class="table">
                    <tr>
                        <th>Município</th>
                        <th>Pesquisador</th>
                        <th>Adicionado em</th>
                        <th colspan="2" class="text-center">Opções</th>
                    </tr>
                    {{-- TODO: Implementar o loop para read das informações da tabela municipios --}}
                    <tr>
                        <td>João Pessoa</td>
                        <td>Renato Bonfim Jr.</td>
                        <td>30/09/2017</td>
                        {{-- TODO: Construit a janela modal para confirmação de exclusão e referenciar a edição --}}
                        <td><button class="btn btn-danger btn-xs">Excluir</button></td>
                        <td><a href="" class="btn btn-primary btn-xs">Editar</a></td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Últimos 20 softwares catalogados --}}
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="lead">Software catalogados</span>
                    <p class="lead pull-right"><i class="fa fa-microchip"></i></p>
                </div>
                <table class="table">
                    <tr>
                        <th>Software</th>
                        <th>Pesquisador</th>
                        <th>Adicionado em</th>
                        <th colspan="2" class="text-center">Opções</th>
                    </tr>
                    {{-- TODO: Implementar o loop para read das informações da tabela programas --}}
                    <tr>
                        <td>SIGov</td>
                        <td>Renato Bonfim Jr.</td>
                        <td>30/09/2017</td>
                        <td><button class="btn btn-danger btn-xs">Excluir</button></td>
                        <td><a href="" class="btn btn-primary btn-xs">Editar</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection