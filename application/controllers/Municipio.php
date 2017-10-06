<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Municipios
 *
 * Responsável pelos metodos exclusivos para interação de municipios
 */
class Municipio extends CI_Controller
{
    // TODO: Inserir PHPDOC ** Urgente: construtor
    public function __construct()
    {
        parent::__construct();
        // Load para o model do municipio
        $this->load->model('municipio_model');
    }
    // TODO: Inserir PHPDOC ** Urgente: data(array)
    private $data = array(
        'title' => 'SIGov 1.0'
    );
    // TODO: Inserir PHPDOC ** Urgente: criarMunicipio
    public function criarMunicipio()
    {
        // Definindo as validações para o formulário de criação de novos municipios
        $this->form_validation->set_rules('nomeMunicipio','Nome do Município','required|xss_clean');
        $this->form_validation->set_rules('densidadeDemografica','Densidade Demográfica','required|xss_clean|numeric|decimal');
        $this->form_validation->set_rules('pibPerCapta','PIB per Capta','required|xss_clean|numeric|decimal');

        // Realizando as verificações do formulário
        if($this->form_validation->run() === FALSE) {
            // Retornando o usuário a página de cadastro de municipios e apresentando os erros
            $this->blade->view('dashboard.municipios',$this->data);
        } else {
            // Inserindo o novo municipio no DB a partir do método criarMunicipio
            $this->municipio_model->criarMunicipio();

            // Retornando ao usuário a informação de sucesso ao inserir
            $this->session->set_flashdata('sucessoAddMunicipio','O município de '.$_POST['nomeMunicipio'].' foi adicionado com sucesso!');

            // Redirecionando para a página de municipios
            redirect('dashboard/municipios');
        }
    }
}