<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Usuario_model
 *
 * Classe responsável pela interação com a tabela usuarios
 */
class Usuario_model extends CI_Model
{
    /**
     * Variáveis globais referentes aos campos da tabela usuarios
     */
    private $idUsuario;
    private $equipe;
    private $perfil;
    private $nomeUsuario;
    private $emailUsuario;
    private $password;
    private $token;
    /*
     |------------------------------------------------------------------------
     | Métodos acessórios
     |------------------------------------------------------------------------
     |
     | Métodos utilizados em outros controllers para recuperar informações,
     | validações e outras ferramentas necessárias ao funcionamento do app.
     |
     | - getAllGestores:    recupera os dados de todos os gestores cadastrados
     | - getAllPli:         recupera os dados de todos os pesquisadores do PLI
     | - getAllPs:          recupera os dados de todos os pesquisadores do PS
     | - verificarToken:    Verifica o token obtido via $_POST autorizando a
     |                      inserção da senha
     |------------------------------------------------------------------------
     */
    /**
     * Function getAllGestores()
     *
     * Método responsável pela recuperação de todos os registros de gestores no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return array $query
     */
    public function getAllGestores()
    {
        // Recuperando todos os registro relativos a gestores no DB
        $this->db->select('idUsuario, nomeUsuario, emailUsuario, descricaoEquipe');
        $this->db->from('usuarios');
        $this->db->join('equipes', 'equipe = idEquipe');
        $this->db->where(array('perfil' => 2));
        $query = $this->db->get();

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /**
     * Function getAllPli()
     *
     * Método responsável pela recuperação de todos os registros de Pesquisadores do PLi no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return mixed
     */
    public function getAllPli()
    {
        // Recuperando todos os registros relativos a Pesquisadores do PLi no DB
        $query = $this->db->get_where('usuarios', array('perfil' => 3, 'equipe' => 2));

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /**
     * Function getAllPs()
     *
     * Método responsável pela recuperação de todos os registrio de Pesquisadores do PS no Db
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return array $query
     */
    public function getAllPs()
    {
        // Recuperado todos os registros relativos a Pesquisadores do PS no DB
        $query = $this->db->get_where('usuarios', array('perfil' => 3, 'equipe' => 3));

        // Retornando o array com os dados de todos os registrios
        return $query->result_array();
    }

    /**
     * Function getIdUsuario()
     *
     * Método responsável por buscar um ID especifico de um usuário no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idUsuario
     * @return mixed
     */
    public function getUsuarioById($idUsuario)
    {
        // Recuperando o registro do usuario no DB a partir de ID
        $query = $this->db->get_where('usuarios', array('idUsuario' => $idUsuario));

        // Retonando a linha relativa ao usuario
        return $query->row();
    }
    /**
     * Function verificarToken()
     *
     * Método responsável pela verificação do token obtido a partir do $_POST['token'] em registro.blade.php
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $token
     * @return bool
     */
    public function verificarToken($token)
    {
        // Verificando a validade do $token
        $query = $this->db->get_where('usuarios', array('token' => $token));

        // Retornando o resultado da consulta ao controller Home
        if($query->num_rows() === 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    /*
     |------------------------------------------------------------------------
     | Métodos principais do Model
     |------------------------------------------------------------------------
     |
     | Métodos utilizados exclusivamente pelo controller Usuario
     |------------------------------------------------------------------------
     */
    /**
     * Function realizarLogin()
     *
     * Método utilizado pelo controller Usuario para realizar o processo de login autenticado no DB
     * 
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return bool
     */
    public function realizarLogin()
    {
        // Recebendo os dados obtidos a partir do formulario de login
        $this->emailUsuario = $_POST['emailUsuario'];
        $this->password     = md5($_POST['password']);

        // Definindo os critérios de busca no Banco de dados
        $this->db->where('emailUsuario',$this->emailUsuario);
        $this->db->where('password',$this->password);

        // Realizando a busca no banco de dados
        $query = $this->db->get('usuarios');

        // Verificando a existência do email e senha adquiridos
        if($query->num_rows() === 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    /**
     * Function criarUsuario()
     *
     * Método utilizado pelo controller Usuario para realizar o processo de inserção de usuarios no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return array $dataUsuario
     */
    public function criarUsuario()
    {
        // Recebendo os dados obtidos a partir do formulário de criação de usuario
        $dataUsuario = array(
            'nomeUsuario'   => $_POST['nomeUsuario'],
            'emailUsuario'  => $_POST['emailUsuario'],
            'equipe'        => $_POST['equipe'],
            'perfil'        => $_POST['perfil'],
            'token'         => sha1(uniqid(rand(),true))
        );

        // Realizando o Insert no DB
        $query = $this->db->insert('usuarios',$dataUsuario);

        // Retornando os dados do usuario para envio do email
        if($query)
            return $dataUsuario;
    }
    /**
     * Function criarSenha()
     *
     * Método utilizado pelo controller Usuario para realizar o processo de inserção de senhas de usuarios no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function criarSenha()
    {
        // Utilizando o token do usuário para a busca no DB
        $this->token = $this->input->post('token');

        // Buscando o usuario a partir do token
        $this->db->select('idUsuario');
        $this->db->where('token', $this->token);
        $query = $this->db->get('usuarios');

        // Obtendo o idUsuario da tabela e convertendo em string
        if($query->num_rows() == 1){
            $idUsuario = $query->row('idUsuario');
        }

        // Recebendo os dados obtidos a partir do formulário de cadastro de senha
        $dataUsuario = array(
            'password'      => md5($_POST['password']),
            'token'         => sha1(uniqid(rand(),true))
        );

        // Atualizando a senha do usuario e criando um novo token
        $this->db->update('usuarios', $dataUsuario, array('idUsuario' => $idUsuario));
    }

    /**
     * Function atualizarUsuario()
     *
     * Método responsável por realizar a atualização dos dados do usuário a partir da requisiaçao Ajax
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idUsuario
     * @return mixed
     */
    public function atualizarUsuario($idUsuario)
    {
        // Recebendo os dados obtidos a partir do formulário de atualização do usuário
        $dataUsuario = array(
            'nomeUsuario'   => $_POST['editarNomeUsuario'],
            'equipe'        => $_POST['editarEquipe'],
            'perfil'        => $_POST['editarPerfil']
        );

        // Atualizando o registro do usuário
        $this->db->update('usuarios', $dataUsuario, $idUsuario);

        // Retornando os dados modificados
        return $this->db->affected_rows();
    }

    /**
     * Funtion buscarEmail()
     *
     * Método responsável por validar a parmissão de alteração de senha de um usuário a partir do email informado
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return bool
     */
    public function buscarEmail()
    {
        // Recebendo o email do usuario via POST
        $this->emailUsuario = $this->input->post('emailUsuario');

        // Buscando o usuário na base de dados
        $this->db->where('emailUsuario', $this->emailUsuario);
        $query = $this->db->get('usuarios');

        // Definindo os parametros para mensagens de sucesso e erro
        if($query->num_rows() === 1) {
            // Retornando os dados do usuario
            return $query->row_array();
        } else {
            // Retornando o erro na busca pelo email
            return FALSE;
        }
    }

    /**
     * Fuuction excluirUsuario()
     *
     * Método responsável por excluir um usuário a partir do seu ID, excluindo resgistros criados pelo mesmo
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idUsuario
     */
    public function excluirUsuario($idUsuario)
    {
        // Definindo as tabelas que deve ser modificadas a partir do idUsuario
        $tabelas = array(
            'programas',
            'municipios',
        );

        // Definindo o campo que serve de paramatro para a busca da FK e excluindo
        $this->db->delete($tabelas, array('responsavelCadastro' => $idUsuario));

        // Definindo o campo que serve de parametro para a idUsuario e excluindo
        $this->db->delete('usuarios', array('idUsuario' => $idUsuario));
    }
}