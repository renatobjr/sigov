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
            <strong>Ops! </strong><br><p>{{ $_SESSION['sucessoAddUsuario'] }}</p>
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
                    {!! form_open('criar_usuario') !!}
                    <li class="list-group-item">
                        <div class="form-group">
                            <label for="nomeUsuario" class="control-label">Nome</label>
                            <input type="text" name="nomeUsuario" value="{{ set_value('nomeUsuario') }}" class="form-control" placeholder="Informe o nome completo">
                        </div>
                        <div class="form-group">
                            <label for="emailUsuario" class="control-label">Endereço de email</label>
                            <input type="email" name="emailUsuario" value="{{ set_value('nome_pessoa') }}" class="form-control" placeholder="Informe um email válido">
                        </div>
                        <div class="form-group">
                            <label for="perfil" class="control-label">Selecione o perfil</label>
                            <select name="perfil" class="form-control">
                                <option value="2">Gestor</option>
                                <option value="3">Pesquisador de Informações - PLi</option>
                                <option value="4">Pesquisador de Software - PS</option>
                            </select>
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
                            <table class="table table-striped">
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th colspan="2" class="text-center">Opções</th>
                                </tr>
                                @foreach($gestores as $gestor)
                                <tr>
                                    <td>{{ $gestor['nomeUsuario'] }}</td>
                                    <td>{{ $gestor['emailUsuario'] }}</td>
                                    <td><button class="btn btn-danger btn-xs">Excluir</button></td>
                                    <td><a href="{{ base_url('editar_usuario/'.$gestor['idUsuario']) }}" class="btn btn-primary btn-xs">Editar</a></td>
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
                                        <span class="lead">Equipe de Levantamento de Informações</span>
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
                                            <td><button class="btn btn-danger btn-xs">Excluir</button></td>
                                            <td><a href="{{ base_url('editar_usuario/'.$pesquisador['idUsuario']) }}" class="btn btn-primary btn-xs">Editar</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Membros da equipe de cadstramento de software --}}
                {{-- TODO: implmentar os loops necessários para exibição da PS --}}
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
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th colspan="2" class="text-center">Opções</th>
                                    </tr>
                                    <tr>
                                        <td>Naamã Oliveira</td>
                                        <td>noliveira@hotmail.com</td>
                                        <td><button class="btn btn-danger btn-xs">Excluir</button></td>
                                        <td><a href="#" class="btn btn-primary btn-xs">Editar</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection