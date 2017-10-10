@extends('dashboard.templates.header')

@section('main')
    @if(isset($_SESSION['loginSucesso']))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>SIGov 1.0 </strong><br><p>{{ $_SESSION['loginSucesso'] }}</p>
        </div>
    @endif
    @if(isset($_SESSION['erroAcesso']))
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>SIGov 1.0 </strong><br><p>{{ $_SESSION['erroAcesso'] }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-4">
            <div class="info-box">
                <span class="bg-info-box info-box-icon">
                    <i class="fa fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span><strong>Usuários</strong></span>
                    <div class="info-box-number">{{ $totalUsuarios }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="info-box">
                <span class="bg-info-box info-box-icon">
                    <i class="fa fa-map-pin"></i>
                </span>
                <div class="info-box-content">
                    <span><strong>Municípios</strong></span>
                    <div class="info-box-number">{{ $totalMunicipios }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="info-box">
                <span class="bg-info-box info-box-icon">
                    <i class="fa fa-microchip"></i>
                </span>
                <div class="info-box-content">
                    <span><strong>Softwares</strong></span>
                    <div class="info-box-number">{{ $totalSoftwares }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Últimos 20 municípios cadastrados --}}
        <div class="col-lg-6">
            <div class="panel-group" id="accordionMunicipios" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="panelMunicipios">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordionMunicipios" href="#collapseMunicipios" aria-expanded="true" aria-controls="collapseMunicipios" style="text-decoration: none">
                                <span class="lead">Municípios cadastrados</span>
                            </a>
                            <p class="lead pull-right"><span class="small">30 últimos registros </span><i class="fa fa-map"></i></p>
                        </h4>
                    </div>
                    <div id="collapseMunicipios" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelMunicipios">
                        @if(empty($municipios))
                            <div class="panel-body">
                                <h6 class="pull-left">Ainda não há Municípios cadastrados!</h6>
                                @if($_SESSION['equipe'] == 2 || $_SESSION['perfil'] == 1)
                                    <a href="{{ base_url('dashboard/municipios') }}" class="btn btn-primary pull-right">Inserir Novo Município</a>
                                @endif
                            </div>
                        @else
                            <table class="table table-striped">
                                <tr>
                                    <th>Município</th>
                                    <th>Pesquisador Responsável</th>
                                    <th>Adicionado em</th>
                                    <th>PIB per Capta</th>
                                </tr>
                                @foreach($municipios as $municipio)
                                    <tr>
                                        <td>{{ $municipio['nomeMunicipio'] }}</td>
                                        <td>{{ $municipio['nomeUsuario'] }}</td>
                                        <td>{{ date('d/m/Y',strtotime($municipio['criadoEm'])) }} às {{ date('H:i',strtotime($municipio['criadoEm'])) }}</td>
                                        <td>R$ <span class="money">{{ $municipio['pibPerCapta'] }}</span></td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- Últimos 20 softwares catalogados --}}
        <div class="col-lg-6">
            <div class="panel-group" id="accordionSoftwares" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="panelSoftwares">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordionSoftwares" href="#collapseSoftwares" aria-expanded="true" aria-controls="collapseSoftwares" style="text-decoration: none">
                                <span class="lead">Softwares catalogados</span>
                            </a>
                            <p class="lead pull-right"><span class="small">30 últimos registros </span><i class="fa fa-microchip"></i></p>
                        </h4>
                    </div>
                    <div id="collapseSoftwares" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelSoftwares">
                        @if(empty($softwares))
                            <div class="panel-body">
                                <h6 class="pull-left">Ainda não há Softwares catalogados!</h6>
                                @if($_SESSION['equipe'] == 3 || $_SESSION['perfil'] == 1)
                                    <a href="{{ base_url('dashboard/softwares') }}" class="btn btn-primary pull-right">Inserir Novo Software</a>
                                @endif
                            </div>
                        @else
                            <table class="table table-striped">
                                <tr>
                                    <th>Software</th>
                                    <th>Pesquisador Responsável</th>
                                    <th>Adicionado em</th>
                                    <th>Área do Software</th>
                                </tr>
                                @foreach($softwares as $software)
                                    <tr>
                                        <td>{{ $software['nomeSoftware'] }}</td>
                                        <td>{{ $software['nomeUsuario'] }}</td>
                                        <td>{{ date('d/m/Y',strtotime($software['criadoEm'])) }} às {{ date('H:i',strtotime($software['criadoEm'])) }}</td>
                                        <td>{{ $software['descricaoArea'] }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para formatar inputs
        $('document').ready(function(){
            $('.money').mask('000.000.000.000.000,00', {reverse: true});
        });
    </script>
@endsection