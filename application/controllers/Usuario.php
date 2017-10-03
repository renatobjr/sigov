<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Usuario
 *
 * Responsável pelos metodos exclusivos para interação de usuários
 */
class Usuario extends CI_Controller
{

    /**
     * Function __construct().
     *
     * Carrega o modelo inicial da classe durante a sua construção
     */
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
     * Function login()
     *
     * Método responsável pelo processo de login do usuário
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
    /**
     * Function logout()
     *
     * Método responsável pelo processo de logout do usuário destruindo os itens de sua sessão
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function logout()
    {
        $this->session->unset_userdata('idUsuario');
        $this->session->unset_userdata('perfil');
        $this->session->unset_userdata('nomeUsuario');
        $this->session->unset_userdata('isLogged');

        redirect();
    }
    /**
     * Function criarUsuario()
     *
     * Método responsável pelo processo de criação de um novo usuário no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function criarUsuario()
    {
        // Definindo as validações para o formulário de criação de novos usuários
        $this->form_validation->set_rules('nomeUsuario','Nome do usuário','required|xss_clean');
        $this->form_validation->set_rules('emailUsuario','E-mail do usuário','required|xss_clean|valid_email');

        // Realizando as verificações do formulário
        if($this->form_validation->run() === FALSE){
            // Criando um array com o conteudo de todos os gestores
            $this->data['gestores'] = $this->usuario_model->getAllGestores();

            // Criando um array com o conteudo de todos os Pesquisadores do PLi
            $this->data['pli'] = $this->usuario_model->getAllPli();

            // Criando um array com o conteudo de todos os Pesquisadores do PS
            $this->data['ps'] = $this->usuario_model->getAllPs();

            // Retornando o usuário a página de Login e apresentando os erros
            $this->blade->view('dashboard.usuarios',$this->data);
        } else {
            // Inserindo o novo usuário no DB a partir do método criarUsuario
            $dadosUsuario = $this->usuario_model->criarUsuario();

            // Enviando o email para o usuário
            $this->enviarEmail('registro', $dadosUsuario['nomeUsuario'], $dadosUsuario['emailUsuario'], $dadosUsuario['token']);

            // Retornando ao usuário a informação de sucesso ao inserir
            $this->session->set_flashdata('sucessoAddUsuario',$_POST['nomeUsuario'].' foi adicionado com sucesso!');

            // Redirecionando para a página de usuário
            redirect('dashboard/equipe');
        }
    }
    /**
     * Function criarSenha()
     *
     * Método responsável pelo processo de criação da senha após envio do link pelo método criarUsuario()
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function criarSenha()
    {
        // Definindo as validações para o formulário de criação de novos usuários
        $this->form_validation->set_rules('password','Senha','trim|required|xss_clean|min_length[8]');
        $this->form_validation->set_rules('confirmarPassword','Confirmação da Senha','trim|required|xss_clean|matches[password]');

        // Realizando as verificações do formulário
        if($this->form_validation->run() === FALSE) {
            // Registrando o token do usuario
            $this->data['token'] = $this->input->post('token');

            // Retornando o usuario a página de cadastro de senha e apresentando erros
            $this->blade->view('registro', $this->data);
        } else {
            // Inserindo a senha para o usuário no DB a partir do método criarSenha
            $this->usuario_model->criarSenha();

            // Retornando ao usuários a informação de sucesso ao atualizar a senha
            $this->session->set_flashdata('sucessoCadastraSenha','Sua senha foi cadastrada com sucesso!');

            // Redirecionando o usuário para a tela de login
            redirect();
        }
    }
    /**
     * Function editarUsuario()
     *
     * Método responsável pela modal e atualização dos dados do usuário via requisição Ajax
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idUsuario
     * @return JSON
     */
    public function editarUsuario($idUsuario)
    {
        // Recebendo a requisição via GET
        $data = $this->usuario_model->getIdUsuario($idUsuario);

        // Retornando o JSON
        echo json_encode($data);
    }
    /**
     * Function atualizarUsuario()
     *
     * Método responsável por atualizar um registro de usuário a partir de uma requisição JSON
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     * @return JSON
     */
    public function atualizarUsuario()
    {
        // Recebendo o ID do usuário que sofrerá a atualização
        $data = $this->usuario_model->atualizarUsuario(array('idUsuario' => $this->input->post('idUsuario')));

        // Retornando o JSON
        echo json_encode(array('status' => TRUE));
    }
    /**
     * Funtion buscarEmail()
     *
     * Método responsável por buscar um email de usuário e definir se há permissão para mudança da senha
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function buscarEmail()
    {
        // Definindo as validações para o formulário de redefinição de senha
        $this->form_validation->set_rules('emailUsuario','Email','trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('confirmarEmail','Confirmação do Email','trim|required|xss_clean|matches[emailUsuario]');

        // Realizando as verificações do formulário
        if($this->form_validation->run() === FALSE) {
            // Retornando o usuario a página de redefinição de senha
            $this->blade->view('redefinir', $this->data);
        } else {
            // Verificando se o usuário esta cadastrado no DB
            $buscarEmail = $this->usuario_model->buscarEmail();

            // Definindo os encaminhamentos para sucesso e erro
            if(!$buscarEmail) {
                // Retornando ao usuários a informação de falha ao buscar email
                $this->session->set_flashdata('emailNaoEncontrado','Não foi possível localizar seu email. Entre em contato com o Administrador do Sistema');

                // Redirecionando o usuário para a tela de email
                redirect('redefinir-senha');
            } else {
                // Enviando o email para o usuário
                $this->enviarEmail('redefinir', $buscarEmail['nomeUsuario'], $buscarEmail['emailUsuario'], $buscarEmail['token']);

                // Retornando ao usuário a informação de sucesso ao inserir
                $this->session->set_flashdata('sucessoRedefinirSenha','Um email foi enviado para '.$buscarEmail['emailUsuario'].' com as instruções para redefinir sua senha');

                // Redirecionando para a página de usuário
                redirect('home');
            }
        }
    }
    /**
     * Funtion excluirUsuario()
     *
     * Método resposável por excluir um usuário a partir do seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idUsuario
     */
    public function excluirUsuario($idUsuario)
    {
        // Chamada para o método excluirUsuário a partir do $idUsuario
        $this->usuario_model->excluirUsuario($idUsuario);

        // Retornando ao usuário a informação de sucesso ao excluir o usuário
        $this->session->set_flashdata('sucessoDelUsuario','Usuário excluído com sucesso.');

        // Redirecionando o usuário para a dashboard
        redirect('dashboard');

    }
    /**
     * Function enviarEmail()
     *
     * Método responsável pelo processo de envio de email após a criação do usuário no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $template
     * @param $nomeUsuario
     * @param $emailUsuario
     * @param $token
     */
    public function enviarEmail($template, $nomeUsuario, $emailUsuario, $token)
    {
        // Configurações iniciais da biblioteca Email
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.googlemail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '60';
        $config['smtp_user']    = 'sistema.sigov@gmail.com';
        $config['smtp_pass']    = 'sistema.sigovpb';
        $config['mailtype']     = 'html';
        $config['charset']      = 'utf-8';

        // Iniciando a biblioteca email
        $this->email->initialize($config);

        // Configuração de envio do email
        $this->email->from('sistema.sigov@gmail.com','SIGov');
        $this->email->to($emailUsuario);
        // Definindo o assunto
        if($template == 'registro') {
            $this->email->subject('Confirmação de cadastro - SIGov');
        } else {
            $this->email->subject('Redefinição de Senha - SIGov');
        }
        $data = array(
            'nomeUsuario'   => $nomeUsuario,
            'emailUsuario'  => $emailUsuario,
            'token'         => $token
        );
        $mensagem = $this->load->view('dashboard/templates/'.$template, $data, TRUE);
        $this->email->message($mensagem);

        // Enviando o email para o usuário
        $this->email->send();
    }
}