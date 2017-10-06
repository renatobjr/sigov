@extends('dashboard.templates.header')

@section('main')
    {!! validation_errors(
        '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! </strong>Verifique se está tudo certo e tente novamente.<br> ',
        '</div>'
    ) !!}
    {{-- Mensagem de sucesso ao inserir o usuário no DB --}}
    @if(isset($_SESSION['sucessoAddUsuario']))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sucesso! </strong><br><p>{{ $_SESSION['sucessoAddUsuario'] }}</p>
        </div>
    @endif
    {{-- Mensagem de sucesso ao excluir o usuário no DB --}}
    @if(isset($_SESSION['sucessoDelUsuario']))
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! </strong><br><p>{{ $_SESSION['sucessoDelUsuario'] }}</p>
        </div>
    @endif
    <div class="row">
        {{-- Formulário para inserção de novos membros das equipes --}}
        <div class="col-lg-4">
            {{-- Painel para inserção de novos usuários --}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="lead">Novo participante</span>
                    <p class="lead pull-right"><i class="fa fa-user-plus fa-fw"></i></p>
                </div>
                <ul class="list-group">
                    {{-- Formulário para a criação de novos usuários --}}
                    {!! form_open('criar-usuario') !!}
                    <li class="list-group-item">
                        <div class="form-group">
                            <label for="nomeUsuario" class="control-label">Nome</label>
                            <input type="text" name="nomeUsuario" value="{{ set_value('nomeUsuario') }}" class="form-control" placeholder="Informe o nome completo">
                        </div>
                        <div class="form-group">
                            <label for="emailUsuario" class="control-label">Endereço de email</label>
                            <input type="email" name="emailUsuario" value="{{ set_value('nome_pessoa') }}" class="form-control" placeholder="Informe um email válido">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="perfil" class="control-label">Selecione o Perfil</label>
                                    <select name="perfil" class="form-control">
                                        <option value="2">Gestor</option>
                                        <option value="3">Pesquisador</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="equipe" class="control-label">Selecione a Equipe</label>
                                    <select name="equipe" class="form-control">
                                        <option value="2">PLi - Municípios</option>
                                        <option valu
                                                ="3">PS - Software</option>
                                    </select>
                                </div>
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
        {{-- Tabela com os gestores cadastrados no sistema --}}
        <div class="col-lg-8">
            <div class="panel-group" id="accordionGestor" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="panelGestor">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordionGestor" href="#collapseGestor" aria-expanded="true" aria-controls="collapseGestor" style="text-decoration: none">
                                <span class="lead">Gestores</span>
                            </a>
                            <p class="lead pull-right"><i class="fa fa-user-secret"></i></p>
                        </h4>
                    </div>
                    <div id="collapseGestor" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelGestor">
                        {{-- Loop inicial para exibição de dados dos gestores --}}
                        @if(empty($gestores))
                            <div class="panel-body">
                                <h5>Ainda não há gestores cadastrados!</h5>
                            </div>
                        @else
                            <table id="id_tabela" class="table table-striped">
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Equipe</th>
                                    <th colspan="2" class="text-center">Opções</th>
                                </tr>
                                @foreach($gestores as $gestor)
                                    <tr>
                                        <td>{{ $gestor['nomeUsuario'] }}</td>
                                        <td>{{ $gestor['emailUsuario'] }}</td>
                                        <td>{{ $gestor['descricaoEquipe'] }}</td>
                                        <td><button class="btn btn-danger btn-sm center-block" data-toggle="modal" data-target=".excluirGestor"><i class="fa fa-trash-o fa-fw"></i></button></td>
                                        <td><button class="btn btn-success btn-sm center-block" onclick="editarUsuario({{ $gestor['idUsuario'] }})"><i class="fa fa-pencil fa-fw"></i></button></td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- Membros da equipe de cadastramento de informações --}}
                <div class="col-lg-6">
                    <div class="panel-group" id="accordionPli" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="panelPli">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionPli" href="#collapsePli" aria-expanded="true" aria-controls="collapsePli" style="text-decoration: none">
                                        <span class="lead">Equipe de Levantamento</span>
                                    </a>
                                    <p class="lead pull-right"><i class="fa fa-map-marker"></i></p>
                                </h4>
                            </div>
                            <div id="collapsePli" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelPli">
                                {{-- Loop inicial para exibição dos dados dos Pli --}}
                                @if(empty($pli))
                                    <div class="panel-body">
                                        <h6>Ainda não há Pesquisadores da equipe PLi cadastrados!</h6>
                                    </div>
                                @else
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th colspan="2" class="text-center">Opções</th>
                                        </tr>
                                        @foreach($pli as $pesquisador)
                                            <tr>
                                                <td>{{ $pesquisador['nomeUsuario'] }}</td>
                                                <td>{{ $pesquisador['emailUsuario'] }}</td>
                                                <td><button class="btn btn-danger btn-sm center-block" data-toggle="modal" data-target=".excluirPli"><i class="fa fa-trash-o fa-fw"></i></button></td>
                                                <td><button class="btn btn-success btn-sm center-block" onclick="editarUsuario({{ $pesquisador['idUsuario'] }})"><i class="fa fa-pencil fa-fw"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Membros da equipe de cadstramento de software --}}
                <div class="col-lg-6">
                    <div class="panel-group" id="accordionPs" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="panelPs">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionPs" href="#collapsePs" aria-expanded="true" aria-controls="collapsePs" style="text-decoration: none">
                                        <span class="lead">Equipe de Software</span>
                                    </a>
                                    <p class="lead pull-right"><i class="fa fa-microchip"></i></p>
                                </h4>
                            </div>
                            <div id="collapsePs" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="panelPs">
                                {{-- Loop inicial para exibição dos dados dos PS --}}
                                @if(empty($ps))
                                    <div class="panel-body">
                                        <h6>Ainda não há Pesquisadores da equipe PS cadastrados!</h6>
                                    </div>
                                @else
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th colspan="2" class="text-center">Opções</th>
                                        </tr>
                                        @foreach($ps as $pesquisador)
                                            <tr>
                                                <td>{{ $pesquisador['nomeUsuario'] }}</td>
                                                <td>{{ $pesquisador['emailUsuario'] }}</td>
                                                <td><button class="btn btn-danger btn-sm center-block" data-toggle="modal" data-target=".excluirPs"><i class="fa fa-trash-o fa-fw"></i></button></td>
                                                <td><button class="btn btn-success btn-sm center-block" onclick="editarUsuario({{ $pesquisador['idUsuario'] }})"><i class="fa fa-pencil fa-fw"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Configuração para as janelas modais --}}
    {{-- Modal para exclusão dos gestores --}}
    <div class="modal fade excluirGestor" tabindex="-1" role="dialog" aria-labelledby="modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmar exclusão?</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir o usuário selecionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    @if(!empty($gestor))
                        <a href="{{ base_url('excluir-usuario/'.$gestor['idUsuario']) }}" class="btn btn-danger">Excluir</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Modal para exclusão dos pesquisadores --}}
    <div class="modal fade excluirPli excluirPs" tabindex="-1" role="dialog" aria-labelledby="modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmar exclusão?</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir o usuário selecionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    @if(!empty($pesquisador))
                        <a href="{{ base_url('excluir-usuario/'.$pesquisador['idUsuario']) }}" class="btn btn-danger">Excluir</a>
                    @endif
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
                    <h4 class="modal-title">Editar usuário</h4>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        {{-- Formulário para a criação de novos usuários --}}
                        {!! form_open('#', 'id="atualizarUsuario"') !!}
                        <input type="hidden" name="idUsuario">
                        <li class="list-group-item">
                            <div class="form-group">
                                <label for="nomeUsuario" class="control-label">Nome</label>
                                <input type="text" name="nomeUsuario" class="form-control" placeholder="Informe o nome completo" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="perfil" class="control-label">Selecione o Perfil</label>
                                        <select name="perfil" class="form-control">
                                            <option value="2">Gestor</option>
                                            <option value="3">Pesquisador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="equipe" class="control-label">Selecione a Equipe</label>
                                        <select name="equipe" class="form-control">
                                            <option value="2">PLi - Municípios</option>
                                            <option value="3">PS - Software</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {!! form_close() !!}
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm center-block" id="atualizarUsuario" onclick="atualizarUsuario()">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $(":input[type=submit]").click(function(){
                $(this).attr("disable", true);
            });

            $(":button[type=submit]").click(function(){
                $(this).html("<i class=\"fa fa-refresh fa-spin fa-fw\"></i>\n" +
                    "                            <span class=\"sr-only\">Loading...</span> Aguarde");
                $(this).attr("disable", true);
            });
        });
        // Função para editar via requisação Ajax os dados do Usuário
        function editarUsuario(idUsuario)
        {
            // Determina o método e o alvo
            save_method = 'update';
            $('#atualizarUsuario')[0].reset();
            // Inicio da requisição Ajax
            $.ajax({
                url:        "{{ base_url('editar-usuario') }}/" + idUsuario,
                type:       "GET",
                dataType:   "JSON",
                success: function(data)
                {
                    $('[name="idUsuario"]').val(data.idUsuario);
                    $('[name="nomeUsuario"]').val(data.nomeUsuario);

                    $('#formModal').modal('show');
                    $('.modalTitulo').text('Editar Usuario');
                }
            });
        }
        // Função para atualizar os dados so usuário
        function atualizarUsuario()
        {
            // Inicio da requisição Ajax
            $.ajax({
                url:        "{{ base_url('atualizar-usuario') }}",
                type:       "POST",
                data:       $('#atualizarUsuario').serialize(),
                dataType:   "JSON",
                success: function(data)
                {
                    $('#formModal').modal('hide');
                    location.reload();
                }
            });
        }
    </script>
@endsection