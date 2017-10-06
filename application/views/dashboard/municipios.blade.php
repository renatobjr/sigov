@extends('dashboard.templates.header')

@section('main')
    {!! validation_errors(
        '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! </strong>Verifique se está tudo certo e tente novamente.<br> ',
        '</div>'
    ) !!}
    @if(isset($_SESSION['sucessoAddMunicipio']))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sucesso! </strong><br><p>{{ $_SESSION['sucessoAddMunicipio'] }}</p>
        </div>
    @endif
<div class="row">
    {{-- Formulário para inserção novos municípios --}}
    <div class="col-lg-6">
        {{-- Painel para inserção de novos municípios --}}
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="lead">Novo município</span>
                <p class="lead pull-right"><i class="fa fa-map-marker fa-fw"></i></p>
            </div>
            <ul class="list-group">
                {{-- Formulário para novo municipio --}}
                {!! form_open('criar-municipio') !!}
                <input type="hidden" name="responsavelCadastro" value="{{ $_SESSION['idUsuario'] }}">
                <li class="list-group-item">
                    <div class="form-group">
                        <label for="nomeMunicipio" class="control-label">Nome</label>
                        <input type="text" name="nomeMunicipio" value="{{ set_value('nomeMunicipio') }}" class="form-control" placeholder="Informe o nome do Município">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="densidadeDemografica" class="control-label">Densidade Demográfica</label>
                                <div class="input-group">
                                    <input type="text" name="densidadeDemografica" value="{{ set_value('densidadeDemografica') }}"class="form-control" placeholder="Informe o total">
                                    <span class="input-group-addon">Hab/km²</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pibPerCapta" class="control-label">PIB per Capta</label>
                                <div class="input-group">
                                    <input type="text" name="pibPerCapta" value="{{ set_value('pibPerCapta') }}"class="form-control" placeholder="Informe o total">
                                    <span class="input-group-addon">R$</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Sistemas de Informação" class="control-label">Sistemas de Informação</label>
                        <p class="small">Assinale os Sistemas de Informação usados pelo Município</p>
                        <div class="checkbox">
                            <label for="sistemaSaude">
                                <input type="checkbox" name="sistemaSaude">  Saúde
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="sistemaEducacao">
                                <input type="checkbox" name="sistemaEducacao">  Educação
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="sistemaPatrimonio">
                                <input type="checkbox" name="sistemaPatrimonio">  Patrimônio
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="sistemaExecucao">
                                <input type="checkbox" name="sistemaExecucao">  Execução Financeira
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="sistemaFolhaPagamento">
                                <input type="checkbox" name="sistemaFolhaPagamento">  Folha de Pagamento
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="sistemaFuncionarios">
                                <input type="checkbox" name="sistemaFuncionarios">  Cadastro de Funcionários
                            </label>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <button type="submit" class="btn btn-primary btn-sm center-block">Cadastrar</button>
                </li>
                {!! form_close() !!}
            </ul>
        </div>
    </div>
    {{-- Tabela com os 30 últimos registros dos municípios cadastrados --}}
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
                            <h5>Ainda não há Municípios cadastrados!</h5>
                        </div>
                    @else
                        <table class="table table-striped">
                            <tr>
                                <th>Município</th>
                                <th>Pesquisados Responsável</th>
                                <th>Data da inserção</th>
                                <th colspan="3" class="text-center">Opções</th>
                            </tr>
                            @foreach($municipios as $municipio)
                                <tr>
                                    <td>{{ $municipio['nomeMunicipio'] }}</td>
                                    <td>{{ $municipio['nomeUsuario'] }}</td>
                                    <td>{{ date('d/m/Y',strtotime($municipio['criadoEm'])) }} às {{ date('H:i',strtotime($municipio['criadoEm'])) }}</td>
                                    <td><button class="btn btn-primary btn-sm center-block"><i class="fa fa-eye fa-fw"></i></button></td>
                                    <td><button class="btn btn-danger btn-sm center-block"><i class="fa fa-trash-o fa-fw"></i></button></td>
                                    <td><button class="btn btn-success btn-sm center-block"><i class="fa fa-pencil fa-fw"></i></button></td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{ print_r($municipios) }}
</div>
@endsection