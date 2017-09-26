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
}