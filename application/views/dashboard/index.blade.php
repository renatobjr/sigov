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
            <div class="panel-group" id="accordionMunicipios" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="panelMunicipios">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordionMunicipios" href="#collapseMunicipios" aria-expanded="true" aria-controls="collapseGestor" style="text-decoration: none">
                                <span class="lead">Municípios</span>
                            </a>
                            <p class="lead pull-right"><i class="fa fa-map-marker"></i></p>
                        </h4>
                    </div>
                    <div id="collapseMunicipios" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelMunicipios">
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
            </div>
        </div>
        {{-- Últimos 20 softwares catalogados --}}
        <div class="col-lg-6">
            <div class="panel-group" id="accordionSoftware" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="panelSoftware">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordionSoftware" href="#collapseSoftware" aria-expanded="true" aria-controls="collapseGestor" style="text-decoration: none">
                                <span class="lead">Softwares Cadastrados</span>
                            </a>
                            <p class="lead pull-right"><i class="fa fa-microchip"></i></p>
                        </h4>
                    </div>
                    <div id="collapseSoftware" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelSoftware">
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
        </div>
    </div>
@endsection