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
    private $perfil;
    private $nomeUsuario;
    private $emailUsuario;
    private $password;
    private $token;
    /*
     |---------------------------------------------------------------------
     | Métodos acessórios
     |---------------------------------------------------------------------
     |
     | Métodos utilizados em outros controllers para recuperar informações
     |
     | - get_all_gestores:  recupera os dados de todos os gestores cadastrados
     | - get_all_pli:       recupera os dados de todos os pesquisadores do PLI
     | - get_all_ps:        recupera os dados de todos os pesquisadores do PS
     */

    /**
     * Método utilizado para recuperar os dados da tabela usuarios com o perfil de gestor [2]
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return mixed
     */
    public function get_all_gestores()
    {
        // Recuperando todos os registro relativos a gestores no DB
        $query = $this->db->get_where('usuarios', array('perfil' => 2));

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }

    public function get_all_pli()
    {
        // Recuperando todos os registros reelativos a Pesquisadores do PLi no DB
        $query = $this->db->get_where('usuarios', array('perfil' => 3));

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /*
     |---------------------------------------------------------------------
     | Métodos principais do Model
     |---------------------------------------------------------------------
     |
     | Métodos utilizados exclusivamente pelo controller Usuario
     */
    /**
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
     * Método responsável pela inserção de novos usuários no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function criarUsuario()
    {
        // Recebendo os dados obtidos a partor do formulário de login
        $usuario = array(
            'nomeUsuario'   => $_POST['nomeUsuario'],
            'emailUsuario'  => $_POST['emailUsuario'],
            'perfil'        => $_POST['perfil'],
            'token'         => sha1(uniqid(rand(),true))
        );

        // Realizando o Insert no DB
        $this->db->insert('usuarios',$usuario);
    }
}