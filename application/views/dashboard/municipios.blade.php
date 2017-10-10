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
    @if(isset($_SESSION['sucessoDelMunicipio']))
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sucesso! </strong><br><p>{{ $_SESSION['sucessoDelMunicipio'] }}</p>
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
                                <div class="input-group">
                                    <label for="nomeMunicipio" class="control-label">Nome</label>
                                    <span class="input-group-addon"><i class="fa fa-tag pull-right"></i></span>
                                </div>
                                <input type="text" name="nomeMunicipio" value="{{ set_value('nomeMunicipio') }}" class="form-control" placeholder="Informe o nome do Município">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="densidadeDemografica" class="control-label">Densidade Demográfica</label>
                                            <span class="input-group-addon"><i class="fa fa-child"></i></span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="densidadeDemografica" value="{{ set_value('densidadeDemografica') }}" class="money form-control" placeholder="Informe o total">
                                            <span class="input-group-addon">Hab/km²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="pibPerCapta" class="control-label">PIB per Capta</label>
                                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">R$</span>
                                            <input type="text" name="pibPerCapta" value="{{ set_value('pibPerCapta') }}" class="money form-control" placeholder="Informe o total">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="Sistemas de Informação" class="control-label">Sistemas de Informação</label>
                                    <span class="input-group-addon"><i class="fa fa-microchip"></i></span>
                                </div>
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
                                <h6>Ainda não há Municípios cadastrados!</h6>
                            </div>
                        @else
                            <table class="table table-striped">
                                <tr>
                                    <th>Município</th>
                                    <th>Pesquisador Responsável</th>
                                    <th>Adicionado em</th>
                                    <th colspan="3" class="text-center">Opções</th>
                                </tr>
                                @foreach($municipios as $municipio)
                                    <tr>
                                        <td>{{ $municipio['nomeMunicipio'] }}</td>
                                        <td>{{ $municipio['nomeUsuario'] }}</td>
                                        <td>{{ date('d/m/Y',strtotime($municipio['criadoEm'])) }} às {{ date('H:i',strtotime($municipio['criadoEm'])) }}</td>
                                        <td><button class="btn btn-primary btn-sm center-block" onclick="visualizarMunicipio({{ $municipio['idMunicipio'] }})"><i class="fa fa-eye fa-fw"></i></button></td>
                                        <td><button class="btn btn-danger btn-sm center-block excluirMunicipio" data-toggle="modal" data-target=".modalMunicipio" data-id="{{ $municipio['idMunicipio'] }}"><i class="fa fa-trash-o fa-fw"></i></button></td>
                                        <td><button class="btn btn-success btn-sm center-block" onclick="editarMunicipio({{ $municipio['idMunicipio'] }})"><i class="fa fa-pencil fa-fw"></i></button></td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Configuração para as janelas modais --}}
        {{-- Modal para visualizar as dados do Município --}}
        <div class="modal fade" id="visualizarModal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title nomeMunicipio"></h4>
                        <small>Município adicionado em <span class="criadoEm"></span> às <span class="horaCriacao"></span> por <span class="nomeUsuario"></span></small>
                    </div>
                    <div class="modal-body">
                        <h5>Informações</h5>
                        <p>
                            O município de <span class="nomeMunicipio"></span> possuí uma densidade demográfica de <span class="densidadeDemografica"></span>
                            Hab/Km² e PIB per Capta no valor de R$ <span class="pibPerCapta"></span>.
                        </p>
                        <h5>Sistemas de Informações disponíveis</h5>
                        <span class="sistemaSaude"></span>
                        <span class="sistemaEducacao"></span>
                        <span class="sistemaPatrimonio"></span>
                        <span class="sistemaExecucao"></span>
                        <span class="sistemaFolhaPagamento"></span>
                        <span class="sistemaFuncionarios"></span>
                        <h5>Recomendações de Software</h5>

                    </div>
                </div>
            </div>
        </div>

        {{-- Modal para confirmar a exclusão do município --}}
        <div class="modal fade modalMunicipio" tabindex="-1" role="dialog" aria-labelledby="modal-label">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirmar exclusão?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir o Município selecionado?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        <a href="" class="btnExcluir btn btn-danger">Excluir</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal para edição --}}
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modalTitulo modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            {{-- Formulario para edição do municipio --}}
                            {!! form_open('#', 'id="atualizarMunicipio"') !!}
                            <input type="hidden" name="responsavelEdicao" value="{{ $_SESSION['idUsuario'] }}">
                            <input type="hidden" name="idMunicipio">
                            <li class="list-group-item">
                                <div class="form-group">
                                    <label for="editarNomeMunicipio" class="control-label">Nome</label>
                                    <input type="text" name="editarNomeMunicipio" class="form-control" placeholder="Informe o nome do Município">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="editarDensidadeDemografica" class="control-label">Densidade Demográfica</label>
                                            <div class="input-group">
                                                <input type="text" name="editarDensidadeDemografica" class="money form-control" placeholder="Informe o total">
                                                <span class="input-group-addon">Hab/km²</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="editarPibPerCapta" class="control-label">PIB per Capta</label>
                                            <div class="input-group">
                                                <input type="text" name="editarPibPerCapta" class="money form-control" placeholder="Informe o total">
                                                <span class="input-group-addon">R$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Sistemas de Informação" class="control-label">Sistemas de Informação</label>
                                    <p class="small">Assinale os Sistemas de Informação usados pelo Município</p>
                                    <div class="checkbox">
                                        <label for="editarSistemaSaude">
                                            <span class="editarSistemaSaude"></span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="editarSistemaEducacao">
                                            <span class="editarSistemaEducacao"></span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="editarSistemaPatrimonio">
                                            <span class="editarSistemaPatrimonio"></span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="editarSistemaExecucao">
                                            <span class="editarSistemaExecucao"></span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="editarSistemaFolhaPagamento">
                                            <span class="editarSistemaFolhaPagamento"></span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="editarSistemaFuncionarios">
                                            <span class="editarSistemaFuncionarios"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            {!! form_close() !!}
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm center-block" id="atualizarMunicipio" onclick="atualizarMunicipio()">Atualizar</button>
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
        // Função modal para levantar os dados do município
        function visualizarMunicipio(idMunicipio) {
            // Inicio da requisição Ajax
            $.ajax({
                url:        "{{ base_url('visualizar-municipio') }}/" + idMunicipio,
                type:       "GET",
                dataType:   "JSON",
                success: function(data)
                {
                    // Informações do Banco
                    $('.nomeMunicipio').html(data.nomeMunicipio);
                    $('.criadoEm').html(data.criadoEm);
                    $('.horaCriacao').html(data.horaCriacao);
                    $('.nomeUsuario').html(data.nomeUsuario);
                    $('.densidadeDemografica').html(data.densidadeDemografica);
                    $('.pibPerCapta').html(data.pibPerCapta);
                    // Definindo o retorno do atributo
                    (data.sistemaSaude == '0') ? $('.sistemaSaude').html('<span class="label label-danger">Não Utiliza Sistemas para Saúde</span>') : $('.sistemaSaude').html('<span class="label label-success">Utiliza Sistemas para Saúde</span>');
                    (data.sistemaEducacao == '0') ? $('.sistemaEducacao').html('<span class="label label-danger">Não Utiliza Sistemas para Educação</span>') : $('.sistemaEducacao').html('<span class="label label-success">Utiliza Sistemas para Educação</span>');
                    (data.sistemaPatrimonio == '0') ? $('.sistemaPatrimonio').html('<span class="label label-danger">Não Utiliza Sistemas para Gestão de Patrimônio</span>') : $('.sistemaPatrimonio').html('<span class="label label-success">Utiliza Sistemas para Gestão de Patrimônio</span>');
                    (data.sistemaExecucao == '0') ? $('.sistemaExecucao').html('<span class="label label-danger">Não Utiliza Sistemas para Execução Financeira</span>') : $('.sistemaExecucao').html('<span class="label label-success">Utiliza Sistemas para Execução Financeira</span>');
                    (data.sistemaFolhaPagamento == '0') ? $('.sistemaFolhaPagamento').html('<span class="label label-danger">Não Utiliza Sistemas para Folha de Pagamento</span>') : $('.sistemaFolhaPagamento').html('<span class="label label-success">Utiliza Sistemas para Folha de Pagamento</span>');
                    (data.sistemaFuncionarios == '0') ? $('.sistemaFuncionarios').html('<span class="label label-danger">Não Utiliza Sistemas para Cadastro de Funcionários</span>') : $('.sistemaFuncionarios').html('<span class="label label-success">Utiliza Sistemas para Cadastro de Funcionários</span>');
                    // Chamada para o modal
                    $('#visualizarModal').modal('show');
                }
            });
        }
        // Função modal para excluir um municipio
        $('.excluirMunicipio').click(function() {
            var idMunicipio = $(this).data('id');
            $('.btnExcluir').attr('href','{{ base_url('excluir-municipio') }}/' + idMunicipio);
        });
        // Função para editar via requisação Ajax os dados do Municipio
        function editarMunicipio(idMunicipio) {
            // Determina o método e o alvo
            save_method = 'update';
            $('#atualizarMunicipio')[0].reset();
            // Iniciando a requisição Ajax
            $.ajax({
                url:        "{{ base_url('editar-municipio') }}/" + idMunicipio,
                type:       "GET",
                dataType:   "JSON",
                success: function(data)
                {
                    $('[name="idMunicipio"]').val(data.idMunicipio);
                    $('[name="editarNomeMunicipio"]').val(data.nomeMunicipio);
                    $('[name="editarDensidadeDemografica"]').val(data.densidadeDemografica);
                    $('[name="editarPibPerCapta"]').val(data.pibPerCapta);
                    (data.sistemaSaude == '1') ? $('.editarSistemaSaude').html('<input type="checkbox" name="editarSistemaSaude" checked>  Saúde') : $('.editarSistemaSaude').html('<input type="checkbox" name="editarSistemaSaude" >  Saúde');
                    (data.sistemaEducacao == '1') ? $('.editarSistemaEducacao').html('<input type="checkbox" name="editarSistemaEducacao" checked>  Educação') : $('.editarSistemaEducacao').html('<input type="checkbox" name="editarSistemaEducacao" >  Educação');
                    (data.sistemaPatrimonio == '1') ? $('.editarSistemaPatrimonio').html('<input type="checkbox" name="editarSistemaPatrimonio" checked>  Patrimônio') : $('.editarSistemaPatrimonio').html('<input type="checkbox" name="editarSistemaPatrimonio" >  Patrimônio');
                    (data.sistemaExecucao == '1') ? $('.editarSistemaExecucao').html('<input type="checkbox" name="editarSistemaExecucao" checked>  Execução Financeira') : $('.editarSistemaExecucao').html('<input type="checkbox" name="editarSistemaExecucao" >  Execução Financeira');
                    (data.sistemaFolhaPagamento == '1') ? $('.editarSistemaFolhaPagamento').html('<input type="checkbox" name="editarSistemaFolhaPagamento" checked>  Folha de Pagamento') : $('.editarSistemaFolhaPagamento').html('<input type="checkbox" name="editarSistemaFolhaPagamento" >  Folha de Pagamento');
                    (data.sistemaFuncionarios == '1') ? $('.editarSistemaFuncionarios').html('<input type="checkbox" name="editarSistemaFuncionarios" checked>  Cadastro de Funcionários') : $('.editarSistemaFuncionarios').html('<input type="checkbox" name="editarSistemaFuncionarios" >  Cadastro de Funcionários');
                    // Chamada para o modal
                    $('#formModal').modal('show');
                    $('.modalTitulo').text(data.nomeMunicipio);
                }
            });
        }
        // Função para atualizar o cadastro do municipio
        function atualizarMunicipio()
        {
            // Inicio da requisição Ajax
            $.ajax({
                url:        "{{ base_url('atualizar-municipio') }}",
                type:       "POST",
                data:       $('#atualizarMunicipio').serialize(),
                dataType:   "JSON",
                success: function (data)
                {
                    $('#formModal').modal('hide');
                    location.reload();
                },
            });
        }
        console.log(atualizarMunicipio)
    </script>
@endsection