<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Home
 *
 * Responsável pelos encaminhamentos das principais views da aplicação
 */
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load para os modelos do usuário e do municipio
        $this->load->model('usuario_model');
        $this->load->model('municipio_model');
        $this->load->model('software_model');

        // Criando um array com o conteudo de todos os gestores
        $this->data['gestores'] = $this->usuario_model->getAllGestores();

        // Criando um array com o conteudo de todos os Pesquisadores do PLi
        $this->data['pli'] = $this->usuario_model->getAllPli();

        // Criando um array com o conteudo de todos os Pesquisadores do PS
        $this->data['ps'] = $this->usuario_model->getAllPs();

        // Criando um array com o conteudo de todos os municipios
        $this->data['municipios'] = $this->municipio_model->getAllMunicipios();

        // Criando um array com todos os softwares
        $this->data['softwares'] = $this->software_model->getAllSoftwares();

        // Criando um array com a contagem dos softwares
        $this->data['totalSoftware'] = $this->software_model->countSoftwaresByArea();
    }
    /**
     * Variável global para informações compartilhadas entre as views
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @var array
     */
    private $data = array(
        'title' => 'SIGov 1.0',
    );
    /**
     * Function index()
     *
     * Método responsável pelo encaminhamento da view principal
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function index()
    {
        // Encaminhamento para a home view
        $this->blade->view('home', $this->data);
    }
    /**
     * Function dashboard()
     *
     * Método responsável pelo encaminhamento da view dashboard
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function dashboard()
    {
        // Encaminhamento para a dashboard view
        $this->blade->view('dashboard.index', $this->data);
    }
    /**
     * Function equipe()
     *
     * Método responsável pelo encaminhamento da view equipe
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function equipe()
    {
        // Definindo acesso a partir do perfil e equipe
        if($_SESSION['perfil'] == 3){
            // Definindo mensagem de erro de acesso
            $this->session->set_flashdata('erroAcesso','Você não tem provilégios para acesso a esta página.');

            // Redirecionando para o index
            redirect('dashboard');
        } else {
            // Encaminhamento para a equipe view
            $this->blade->view('dashboard.usuarios', $this->data);
        }
    }

    public function municipio()
    {
        // Definindo acesso a partir do perfil e equipe
        if($_SESSION['equipe'] == 2 || $_SESSION['perfil'] == 1){
            // Encaminhamento para a municipio view
            $this->blade->view('dashboard.municipios', $this->data);
        } else {
            // Definindo mensagem de erro de acesso
            $this->session->set_flashdata('erroAcesso','Você não tem provilégios para acesso a esta página.');

            // Redirecionando para o index
            redirect('dashboard');
        }
    }

    public function software()
    {
        // Definindo acesso a partir do perfil e equipe
        if($_SESSION['equipe'] == 3 || $_SESSION['perfil'] == 1){
            // Encaminhamento para a software view
            $this->blade->view('dashboard.softwares', $this->data);
        } else {
            // Definindo mensagem de erro de acesso
            $this->session->set_flashdata('erroAcesso','Você não tem provilégios para acesso a esta página.');

            // Redirecionando para o index
            redirect('dashboard');
        }
    }
    /**
     * Function registro()
     *
     * Método responsável pelo encaminhamento da view registro
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function registro()
    {
        // Recebendo o token via $_GET(ULR) e encaminhando ao método verificador
        $token = $_GET['token'];

        // Realizando o load do Usuario_model
        $this->load->model('usuario_model');

        // Reencaminhando o token do usuário para a verificação
        $validarToken = $this->usuario_model->verificarToken($token);

        // Realizando a permissão de cadastramento da senha
        if(!$validarToken){
            $this->blade->view('dashboard.templates.erroToken', $this->data);
        } else {
            // Armazenando o token do usuário
            $this->data['token'] = $token;

            // Encaminhamento para a registro view
            $this->blade->view('registro', $this->data);
        }
    }

    public function redefinirSenha()
    {
        // Encaminhamento para a redifinição da senha
        $this->blade->view('redefinir', $this->data);
    }
}