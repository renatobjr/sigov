<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Home
 *
 * Responsável pelos encaminhamentos das principais views da aplicação
 */
class Home extends CI_Controller
{
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
        // Realizando o load do Usuario_model
        $this->load->model('usuario_model');

        // Criando um array com o conteudo de todos os gestores
        $this->data['gestores'] = $this->usuario_model->getAllGestores();

        // Criando um array com o conteudo de todos os Pesquisadores do PLi
        $this->data['pli'] = $this->usuario_model->getAllPli();

        // Criando um array com o conteudo de todos os Pesquisadores do PS
        $this->data['ps'] = $this->usuario_model->getAllPs();

        // Encaminhamento para a equipe view
        $this->blade->view('dashboard.usuarios', $this->data);
    }

    public function municipio()
    {
        // Encaminhamento para a municipio view
        $this->blade->view('dashboard.municipios', $this->data);
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