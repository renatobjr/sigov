@extends('dashboard.templates.header')

@section('main')
    {!! validation_errors(
        '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! </strong>Verifique se está tudo certo e tente novamente.<br> ',
        '</div>'
    ) !!}
    @if(isset($_SESSION['sucessoAddSoftware']))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sucesso! </strong><br><p>{{ $_SESSION['sucessoAddSoftware'] }}</p>
        </div>
    @endif
    @if(isset($_SESSION['sucessoDelSoftware']))
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! </strong><br><p>{{ $_SESSION['sucessoDelSoftware'] }}</p>
        </div>
    @endif
    <div class="row">
        {{-- Formulário para a inserção de novos softwares --}}
        <div class="col-lg-6">
            {{-- Painel para a inserção de novos softwares --}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="lead">Novo Software Público</span>
                    <p class="lead pull-right"><i class="fa fa-microchip fa-fw"></i></p>
                </div>
                <ul class="list-group">
                    {{-- Formulário para um novo software --}}
                    {!! form_open('criar-software') !!}
                    <input type="hidden" name="responsavelCadastro" value="{{ $_SESSION['idUsuario'] }}">
                        <li class="list-group-item">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="nomeSoftware" class="control-label">Nome do Software</label>
                                    <span class="input-group-addon"><i class="fa fa-tag pull-right"></i></span>
                                </div>
                                <input type="text" name="nomeSoftware" value="{{ set_value('nomeSoftware') }}" class="form-control" placeholder="Informe o nome do Software">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="descricaoSoftware" class="control-label">Descrição do Software</label>
                                    <span class="input-group-addon"><i class="fa fa fa-archive pull-right"></i></span>
                                </div>
                                <textarea name="descricaoSoftware" value="{{ set_value('descricaoSoftware') }}" cols="30" rows="3" class="form-control" placeholder="Descreva as principais funcionalidades e objetivos do software"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="requerimentoMemoria" class="control-label">Requerimento RAM</label>
                                            <span class="input-group-addon"><i class="fa fa-server pull-right"></i></span>
                                        </div>
                                        <input type="text" name="requerimentoMemoria" value="{{ set_value('requerimentoMemoria') }}" class="form-control" placeholder="Em Megabytes">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="requerimentoProcessador" class="control-label">Processador</label>
                                            <span class="input-group-addon"><i class="fa fa-desktop pull-right"></i></span>
                                        </div>
                                        <input type="text" name="requerimentoProcessador" value="{{ set_value('requerimentoProcessador') }}" class="form-control" placeholder="Frequência Ghz">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="requerimentoDisco" class="control-label">Espaço em disco</label>
                                            <span class="input-group-addon"><i class="fa fa-hdd-o pull-right"></i></span>
                                        </div>
                                        <input type="text" name="requerimentoDisco" value="{{ set_value('requerimentoDisco') }}" class="form-control" placeholder="Em Megabytes">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="requerimentoSoftware" class="control-label">Sistema Operacional</label>
                                            <span class="input-group-addon"><i class="fa fa-keyboard-o pull-right"></i></span>
                                        </div>
                                        <input type="text" name="requerimentoSoftware" value="{{ set_value('requerimentoSoftware') }}" class="form-control" placeholder="Windows, GNU/Linux e Mac OSx">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="requerimentoLinguagem" class="control-label">Pré-requisitos</label>
                                            <span class="input-group-addon"><i class="fa fa-code pull-right"></i></span>
                                        </div>
                                        <input type="text" name="requerimentoLinguagem" value="{{ set_value('requerimentoLinguagem') }}" class="form-control" placeholder="C#, Java, Python e outros">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="dataPublicacao" class="control-label">Data de Publicação</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar pull-right"></i></span>
                                        </div>
                                        <input type="text" name="dataPublicacao" value="{{ set_value('dataPublicacao') }}" class="date form-control" placeholder="Publicação do software">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="ultimaAtualizacao" class="control-label">Última Atualizaçao</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar pull-right"></i></span>
                                        </div>
                                        <input type="text" name="ultimaAtualizacao" value="{{ set_value('ultimaAtualizacao') }}" class="date form-control" placeholder="Data da Última atualização">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="areaSoftware" class="control-label">Área do Software</label>
                                            <span class="input-group-addon"><i class="fa fa-hashtag pull-right"></i></span>
                                        </div>
                                        <select name="areaSoftware" class="form-control">
                                            <option value="1">Saúde</option>
                                            <option value="2">Educação</option>
                                            <option value="3">Patrimônio</option>
                                            <option value="4">Execução</option>
                                            <option value="5">Folha de Pagamento</option>
                                            <option value="6">Cadastro de Funcionários</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="siteSoftware" class="control-label">Site do Desenvolvedor</label>
                                            <span class="input-group-addon"><fa class="fa fa-chain"></fa></span>
                                        </div>
                                        <input type="text" name="siteSoftware" value="{{ set_value('siteSoftware') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="manualSoftware" class="control-label">Manual do software(Link)</label>
                                    <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                </div>
                                <input type="text" name="manualSoftware" value="{{ set_value('manualSoftware') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="observacao" class="control-label">Observações</label>
                                    <span class="input-group-addon"><i class="fa fa fa-eye pull-right"></i></span>
                                </div>
                                <textarea name="observacoes" value="{{ set_value('observacoes') }}" cols="30" rows="3" class="form-control" placeholder="Descreva informações sobre o software que você considera relevante."></textarea>
                            </div>
                        </li>
                    <li class="list-group-item">
                        <button type="submit" class="btn btn-primary btn-sm center-block">Cadastrar</button>
                    </li>
                    {!! form_close() !!}
                </ul>
            </div>
        </div>

        {{-- Quantidade de Softwares cadastrados por área--}}
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-4">
                    <div class="info-box">
                        <span class="bg-info-box info-box-icon">
                            <i class="fa fa-heartbeat"></i>
                        </span>
                        <div class="info-box-content">
                            <span><strong>Saúde</strong></span>
                            <div class="info-box-number">{{ empty($totalSoftwareByArea['saude']) ? 0 : $totalSoftwareByArea['saude']}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box">
                        <span class="bg-info-box info-box-icon">
                            <i class="fa fa-graduation-cap"></i>
                        </span>
                        <div class="info-box-content">
                            <span><strong>Educação</strong></span>
                            <div class="info-box-number">{{ empty($totalSoftwareByArea['educacao']) ? 0 : $totalSoftwareByArea['educacao'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box">
                        <span class="bg-info-box info-box-icon">
                            <i class="fa fa-building"></i>
                        </span>
                        <div class="info-box-content">
                            <span><strong>Patrimônio</strong></span>
                            <div class="info-box-number">{{ empty($totalSoftwareByArea['patrimonio']) ? 0 : $totalSoftwareByArea['patrimonio'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="info-box">
                        <span class="bg-info-box info-box-icon">
                            <i class="fa fa-money"></i>
                        </span>
                        <div class="info-box-content">
                            <span><strong>Execução</strong></span>
                            <div class="info-box-number">{{ empty($totalSoftwareByArea['execucao']) ? 0 : $totalSoftwareByArea['execucao'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box">
                        <span class="bg-info-box info-box-icon">
                            <i class="fa fa-credit-card"></i>
                        </span>
                        <div class="info-box-content">
                            <span><strong>Pagamento</strong></span>
                            <div class="info-box-number">{{ empty($totalSoftwareByArea['folhaPagamento']) ? 0 : $totalSoftwareByArea['folhaPagamento'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box">
                        <span class="bg-info-box info-box-icon">
                            <i class="fa fa-child"></i>
                        </span>
                        <div class="info-box-content">
                            <span><strong>Funcionários</strong></span>
                            <div class="info-box-number">{{ empty($totalSoftwareByArea['cadastroFuncionarios']) ? 0 : $totalSoftwareByArea['cadastroFuncionarios'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabela com os 30 últimos registros dos municípios cadastrados --}}
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
                                <h6>Ainda não há Softwares Catalogados!</h6>
                            </div>
                        @else
                            <table class="table table-striped">
                                <tr>
                                    <th>Software</th>
                                    <th>Pesquisador Responsável</th>
                                    <th>Adicionado em</th>
                                    <th colspan="3" class="text-center">Opções</th>
                                </tr>
                                @foreach($softwares as $software)
                                    <tr>
                                        <td>{{ $software['nomeSoftware'] }}</td>
                                        <td>{{ $software['nomeUsuario'] }}</td>
                                        <td>{{ date('d/m/Y',strtotime($software['criadoEm'])) }} às {{ date('H:i',strtotime($software['criadoEm'])) }}</td>
                                        <td><button class="btn btn-primary btn-sm center-block" onclick="visualizarSoftware({{ $software['idPrograma'] }})"><i class="fa fa-eye fa-fw"></i></button></td>
                                        <td><button class="btn btn-danger btn-sm center-block excluirSoftware" data-toggle="modal" data-target=".modalSoftware" data-id="{{ $software['idPrograma'] }}"><i class="fa fa-trash-o fa-fw"></i></button></td>
                                        <td><button class="btn btn-success btn-sm center-block" onclick="editarSoftware({{ $software['idPrograma'] }})"><i class="fa fa-pencil fa-fw"></i></button></td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Configuração para as janelas modais --}}
    {{-- Modal para visualizar as dados do Município --}}
    <div class="modal fade" id="visualizarModal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
        <div class="modal-dialog"role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title nomeSoftware"></h4>
                    <small>Software catalogado em  <span class="criadoEm"></span> às <span class="horaCriacao"></span> por <span class="nomeUsuario"></span></small>
                </div>
                <div class="modal-body">
                    <h5>Descrição</h5>
                    <p class="descricaoSoftware"></p>
                    <h5>Requerimentos Mínimos:</h5>
                    <p>Memória RAM: <span class="requerimentoMemoria"></span> Mb</p>
                    <p>Processador: <span class="requerimentoProcessador"></span> GHz</p>
                    <p>Espaço em disco: <span class="requerimentoDisco"></span> Mb</p>
                    <p>Sistemas Operacionais: <span class="requerimentoSoftware"></span></p>
                    <p>Pré-requisitos: <span class="requerimentoLinguagem"></span></p>
                    <h5>Informações Adicionais</h5>
                    <p>Site do Desenvolvedor: <a href="" class="siteSoftware" target="_blank"><span class="nomeSoftware"></span></a></p>
                    <p><a href="" class="manualSoftware" target="_blank">Documentação do Software</a></p>
                    <p>Área de aplicação do software: <span class="descricaoArea"></span></p>
                    <p><span class="observacoes"></span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para a exclusão --}}
    <div class="modal fade modalSoftware" tabindex="-1" role="dialog" aria-labelledby="modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmar exclusão?</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir o Software selecionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <a href="" class="btnExcluir btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para edição do software --}}
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modalTitulo modal-title"></h4>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        {{-- Formulario para edição do municipio --}}
                        {!! form_open('#', 'id="atualizarSoftware"') !!}
                        <input type="hidden" name="responsavelEdicao" value="{{ $_SESSION['idUsuario'] }}">
                        <input type="hidden" name="idPrograma">
                        <li class="list-group-item">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="editarNomeSoftware" class="control-label">Nome do Software</label>
                                    <span class="input-group-addon"><i class="fa fa-tag pull-right"></i></span>
                                </div>
                                <input type="text" name="editarNomeSoftware" class="form-control" placeholder="Informe o nome do Software">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="editarDescricaoSoftware" class="control-label">Descrição do Software</label>
                                    <span class="input-group-addon"><i class="fa fa fa-archive pull-right"></i></span>
                                </div>
                                <textarea name="editarDescricaoSoftware" cols="30" rows="3" class="form-control" placeholder="Descreva as principais funcionalidades e objetivos do software"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarRequerimentoMemoria" class="control-label">Requerimento RAM</label>
                                            <span class="input-group-addon"><i class="fa fa-server pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarRequerimentoMemoria" class="form-control" placeholder="Em Megabytes">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarRequerimentoProcessador" class="control-label">Processador</label>
                                            <span class="input-group-addon"><i class="fa fa-desktop pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarRequerimentoProcessador" class="form-control" placeholder="Frequência Ghz">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarRequerimentoDisco" class="control-label">Espaço em disco</label>
                                            <span class="input-group-addon"><i class="fa fa-hdd-o pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarRequerimentoDisco" class="form-control" placeholder="Em Megabytes">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarRequerimentoSoftware" class="control-label">Sistema Operacional</label>
                                            <span class="input-group-addon"><i class="fa fa-keyboard-o pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarRequerimentoSoftware" class="form-control" placeholder="Windows, GNU/Linux e Mac OSx">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarRequerimentoLinguagem" class="control-label">Pré-requisitos</label>
                                            <span class="input-group-addon"><i class="fa fa-code pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarRequerimentoLinguagem" class="form-control" placeholder="C#, Java, Python e outros">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarDataPublicacao" class="control-label">Data de Publicação</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarDataPublicacao" class="date form-control" placeholder="Publicação do software">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarUltimaAtualizacao" class="control-label">Última Atualizaçao</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar pull-right"></i></span>
                                        </div>
                                        <input type="text" name="editarUltimaAtualizacao" class="date form-control" placeholder="Data da Última atualização">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarAreaSoftware" class="control-label">Área do Software</label>
                                            <span class="input-group-addon"><i class="fa fa-hashtag pull-right"></i></span>
                                        </div>
                                        <select name="editarAreaSoftware" class="form-control">
                                            <option value="1">Saúde</option>
                                            <option value="2">Educação</option>
                                            <option value="3">Patrimônio</option>
                                            <option value="4">Execução</option>
                                            <option value="5">Folha de Pagamento</option>
                                            <option value="6">Cadastro de Funcionários</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="editarSiteSoftware" class="control-label">Site do Desenvolvedor</label>
                                            <span class="input-group-addon"><fa class="fa fa-chain"></fa></span>
                                        </div>
                                        <input type="text" name="editarSiteSoftware" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="editarManualSoftware" class="control-label">Manual do software(Link)</label>
                                    <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                </div>
                                <input type="text" name="editarManualSoftware" class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="editarObservacoes" class="control-label">Observações</label>
                                    <span class="input-group-addon"><i class="fa fa fa-eye pull-right"></i></span>
                                </div>
                                <textarea name="editarObservacoes" cols="30" rows="3" class="form-control" placeholder="Descreva informações sobre o software que você considera relevante."></textarea>
                            </div>
                        </li>
                        {!! form_close() !!}
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm center-block" id="atualizarSoftware" onclick="atualizarSoftware()">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Função para formatar inputs
        $('document').ready(function(){
            $('.date').mask('00/00/0000', {reverse: true});
        });
        // Função para substituição do botão submit e trava do formulário
        $(function () {
            $(":input[type=submit]").click(function(){
                $(this).attr("id=\"disabledInput\" disabled", true);
            });

            $(":button[type=submit]").click(function(){
                $(this).html("<i class=\"fa fa-refresh fa-spin fa-fw\"></i>\n" +
                    "                            <span class=\"sr-only\">Loading...</span> Aguarde");
                $(this).attr("id=\"disabledInput\" disabled", true);
            });
        });
        // Função para visualizar as informações do software
        function visualizarSoftware(idPrograma){
            // Iniciando uma requesição Ajax
            $.ajax({
                url:        "{{ base_url('visualizar-software') }}/" + idPrograma,
                type:       "GET",
                dataType:   "JSON",
                success: function (data)
                {
                    // Informações do Banco
                    $('.nomeSoftware').html(data.nomeSoftware);
                    $('.criadoEm').html(data.criadoEm);
                    $('.horaCriacao').html(data.horaCriacao);
                    $('.nomeUsuario').html(data.nomeUsuario);
                    $('.descricaoSoftware').html(data.descricaoSoftware);
                    $('.requerimentoMemoria').html(data.requerimentoMemoria);
                    $('.requerimentoProcessador').html(data.requerimentoProcessador);
                    $('.requerimentoDisco').html(data.requerimentoDisco);
                    $('.requerimentoSoftware').html(data.requerimentoSoftware);
                    $('.requerimentoLinguagem').html(data.requerimentoLinguagem);
                    $('.siteSoftware').attr('href','http://'+(data.siteSoftware));
                    $('.manualSoftware').attr('href','http://'+(data.manualSoftware));
                    $('.descricaoArea').html(data.descricaoArea);
                    $('.observacoes').html(data.observacoes);
                    // Chamada para o modal
                    $('#visualizarModal').modal('show');
                }
            });
        }
        // Função modal para excluir um software
        $('.excluirSoftware').click(function () {
            var idPrograma = $(this).data('id');
            $('.btnExcluir').attr('href','{{ base_url('excluir-software') }}/' + idPrograma);
        })
        function editarSoftware(idPrograma)
        {
            // Determina o método e o alvo
            save_method = 'update';
            $('#atualizarSoftware')[0].reset();
            // Iniciando Requisição Ajax
            $.ajax({
                url:        "{{ base_url('editar-software')  }}/" + idPrograma,
                type:       "GET",
                dataType:   "JSON",
                success: function (data)
                {
                    $('[name="idPrograma"]').val(data.idPrograma);
                    $('[name="editarNomeSoftware"]').val(data.nomeSoftware);
                    $('[name="editarDescricaoSoftware"]').val(data.descricaoSoftware);
                    $('[name="editarRequerimentoMemoria"]').val(data.requerimentoMemoria);
                    $('[name="editarRequerimentoProcessador"]').val(data.requerimentoProcessador);
                    $('[name="editarRequerimentoDisco"]').val(data.requerimentoDisco);
                    $('[name="editarRequerimentoSoftware"]').val(data.requerimentoSoftware);
                    $('[name="editarRequerimentoLinguagem"]').val(data.requerimentoLinguagem);
                    $('[name="editarDataPublicacao"]').val(data.formatDataPublicacao);
                    $('[name="editarUltimaAtualizacao"]').val(data.formatUltimaAtualizacao);
                    $('[name="editarAreaSoftware"]').val(data.areaSoftware);
                    $('[name="editarSiteSoftware"]').val(data.siteSoftware);
                    $('[name="editarManualSoftware"]').val(data.manualSoftware);
                    $('[name="editarObservacoes"]').val(data.observacoes);
                    // Chamada para o modal
                    $('#formModal').modal('show');
                    $('.modalTitulo').text(data.nomeSoftware);
                }
            });
        }
        // Função para atualizar o cadastro do software
        function atualizarSoftware()
        {
            // Iniciando requisição ajax
            $.ajax({
               url:         "{{ base_url('atualizar-software') }}",
               type:        "POST",
               data:        $('#atualizarSoftware').serialize(),
               dataType:    "JSON",
               success: function(data)
               {
                    $('#formModal').modal('hide');
                    location.reload();
               }
            });
        }
    </script>
@endsection
