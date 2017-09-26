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
    private $linkReset;

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
}