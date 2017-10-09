<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Software
 *
 * Responsável pelos metodos exclusivos para interação de softwares
 */
class Software extends CI_Controller
{
    /**
     * Software constructor.
     *
     * Carrega o modelo inicial da classe durante a sua construção
     */
    public function __construct()
    {
        parent::__construct();
        // Load para o modelo de software
        $this->load->model('software_model');

        // Criando um array com todos os softwares
        $this->data['softwares'] = $this->software_model->getAllSoftwares();

        // Criando um array com a contagem de softwares catalogados
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
        'title' => 'SIGov 1.0'
    );
    /**
     * Function criarSoftware()
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     */
    public function criarSoftware()
    {
        // Definindo as validações para o formulário de catalogo de novos softwares
        $this->form_validation->set_rules('nomeSoftware','Nome do Software','required|xss_clean');
        $this->form_validation->set_rules('descricaoSoftware','Descrição do Software','required|xss_clean');
        $this->form_validation->set_rules('requerimentoMemoria','Requerimento Memória RAM','required|xss_clean|numeric');
        $this->form_validation->set_rules('requerimentoProcessador','Processador','required|xss_clean|numeric|decimal');
        $this->form_validation->set_rules('requerimentoDisco','Espaço em Disco','required|xss_clean|numeric');
        $this->form_validation->set_rules('requerimentoSoftware','Sistema Operacional','required|xss_clean');
        $this->form_validation->set_rules('requerimentoLinguagem','Pré-requsitos','required|xss_clean');
        $this->form_validation->set_rules('dataPublicacao','Data de Publicação do Software','required|xss_clean');
        $this->form_validation->set_rules('ultimaAtualizacao','Data de última atualização do Software','required|xss_clean');
        $this->form_validation->set_rules('areaSoftware','Área do Software','required|xss_clean');
        $this->form_validation->set_rules('siteSoftware','Link para Página do Software','required|xss_clean|valid_url');
        $this->form_validation->set_rules('manualSoftware','Link para Maual do Software','required|xss_clean|valid_url');

        // Realizando as verificações do formulário
        if($this->form_validation->run() === FALSE){
            // Retornando o usuário a página de catalogo de software e apresentando os erros
            $this->blade->view('dashboard.softwares', $this->data);
        } else {
            // Inserindo o novo software no DB a partir do método criarSoftware
            $this->software_model->criarSoftware();

            // Retornando ao usuário a informação de sucesso ao inserir
            $this->session->set_flashdata('sucessoAddSoftware','O Software'.$_POST['nomeSoftware'].' foi catalogado com sucesso!');

            // Redirecionando para a página de municipios
            redirect('dashboard/softwares');
        }
    }
    /**
     * Fuction visualizarSoftware()
     *
     * Método responsável por buscar as informações do Software
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     * @param $idPrograma
     * @return JSON
     */
    public function visualizarSoftware($idPrograma)
    {
        // Recebendo a requisição via GET
        $data = $this->software_model->getSotwareById($idPrograma);

        // Retornando o JSON
        echo json_encode($data);
    }
    /**
     * Function editarSoftware
     *
     * Método responsável por buscar as informações do Software e permitir sua edição
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idPrograma
     * @return JSON
     */
    public function editarSoftware($idPrograma)
    {
        // Recebendo a requisição via GET
        $data = $this->software_model->getIdSoftware($idPrograma);

        // Retornando o JSON
        echo json_encode($data);
    }
    /**
     * Function altualizarSoftware()
     *
     * Método responsável por salvar no banco de dados s alterações do cadastro de software
     */
    public function atualizarSoftware()
    {
        // Recebendo o ID do software que sofrerá a atualização
        $this->software_model->atualizarSoftware(array('idPrograma' => $this->input->post('idPrograma')));

        // Retornando o JSON
        echo json_encode(array('status' => TRUE));
    }
    /**
     * Function excluirSoftware()
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idPrograma
     */
    public function excluirSoftware($idPrograma)
    {
        // Chamada para o método excluirSoftware a partir do $idPrograma
        $this->software_model->excluirSoftware($idPrograma);

        // Retornando ao usuário a informação de exclusão do software
        $this->session->set_flashdata('sucessoDelSoftware','Software excluído com sucesso.');

        // Redirecionando o usuário para a dashboard
        redirect('dashboard/softwares');
    }
}