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

    public function dashboard()
    {
        // Encaminhamento para a dashboard view
        $this->blade->view('dashboard.index', $this->data);
    }

    public function equipe()
    {
        // Realizando o load do Usuari_model
        $this->load->model('usuario_model');

        // Criando um array com o conteudo de todos os gestores
        $this->data['gestores'] = $this->usuario_model->get_all_gestores();

        // Criando um array com o conteudo de todos os Pesquisadores do PLi
        $this->data['pli'] = $this->usuario_model->get_all_pli();

        // Encaminhamento para a equipe view
        $this->blade->view('dashboard.usuario', $this->data);
    }
}