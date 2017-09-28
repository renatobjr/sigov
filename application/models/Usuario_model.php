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
        $query = $this->db->get_where('usuarios', array('perfil' => 2));

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
        // Recuperando todos os registros reelativos a Pesquisadores do PLi no DB
        $query = $this->db->get_where('usuarios', array('perfil' => 3, 'equipe' => 2));

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
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
        // Recebendo os dados obtidos a partir do formulário de login
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
        $token = $this->input->post('token');

        // Buscando o usuario a partir do token
        $this->db->select('idUsuario');
        $this->db->where('token', $token);
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
}