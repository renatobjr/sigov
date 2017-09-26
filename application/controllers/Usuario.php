<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Usuario
 *
 * Responsável pelos metodos exclusivos para interação de usuários
 */
class Usuario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    /**
     * Variável global para informações compartilhadas entre as views
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @var array
     */
    private $data = array(
        'title' => 'SIGov 1.0'
    );
    /**
     * Método para realizar o login do usuário e definir sua dashboard a partir do perfil
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return void
     */
    public function login()
    {
        // Definindo as validações para o formulário de Login
        $this->form_validation->set_rules('emailUsuario','E-mail','required|xss_clean|valid_email');
        $this->form_validation->set_rules('password','Senha','required|xss_clean');

        // Realizando as verificações do formulário
        if($this->form_validation->run() === FALSE) {
            // Retornando o usuário a página de Login e apresentando os erros
            $this->blade->view('home',$this->data);
        } else {
            // Chamada o método responsável por realizar o login do usuário
            $login = $this->usuario_model->realizarLogin();

            // Verifica se o login foi realizado de forma correta e reencaminha o usuário para a view correspondente
            if($login) {
                // Adquire os dados para inicializar a sessão do usuário
                $dataUsuario = array(
                    'idUsuario'     => $login['idUsuario'],
                    'perfil'        => $login['perfil'],
                    'nomeUsuario'   => $login['nomeUsuario'],
                    'isLogged'      => TRUE
                );

                // Cria a sessão do usuário e determina sua view
                $this->session->set_userdata($dataUsuario);

                // Configura a mensagem de login realizado com sucesso
                $this->session->set_flashdata('loginSucesso','Olá '.$login['nomeUsuario'].'. Seja bem vindo ao SIGov');

                // Determinando a view correspondente
                redirect('dashboard',$dataUsuario);
            } else {
                // Configura a mensagem de erro ao logar
                $this->session->set_flashdata('loginErro','Não foi possível realizar o login. Verifique suas credenciais.');

                // Redirecionando para a página inicial e apresentando o erro relativo ao login do usuario
                redirect();
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('idUsuario');
        $this->session->unset_userdata('perfil');
        $this->session->unset_userdata('nomeUsuario');
        $this->session->unset_userdata('isLogged');

        redirect();
    }
}