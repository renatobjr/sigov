<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Municipios
 *
 * Responsável pelos metodos exclusivos para interação de municipios
 */
class Municipio extends CI_Controller
{
    /**
     * Municipio constructor.
     *
     * Carrega o modelo inicial da classe durante a sua construção
     */
    public function __construct()
    {
        parent::__construct();
        // Load para o model do municipio
        $this->load->model('municipio_model');
    }
    /**
     * Variável global para informações compartilhadas entre as vies
     *
     * @since 1.0
     * @author RenatoBonfim Jr.
     * @var array
     */
    private $data = array(
        'title' => 'SIGov 1.0'
    );
    /**
     * Fuction criarMunicipio()
     *
     * Método responsável por adicionar um novo municipio ao DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return void
     */
    public function criarMunicipio()
    {
        // Definindo as validações para o formulário de criação de novos municipios
        $this->form_validation->set_rules('nomeMunicipio','Nome do Município','required|xss_clean');
        $this->form_validation->set_rules('densidadeDemografica','Densidade Demográfica','required|xss_clean');
        $this->form_validation->set_rules('pibPerCapta','PIB per Capta','required|xss_clean');

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
    /**
     * Function visualizarMunicipio()
     *
     * Método responsável pela visualização das informações do municipio a partir do seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idMunicipio
     * @return JSON $data
     */
    public function visualizarMunicipio($idMunicipio)
    {
        // Recebendo a requisição via GET
        $data = $this->municipio_model->getMunicipioById($idMunicipio);

        // Retornando o JSON
        echo json_encode($data);
    }
    /**
     * Fuction editarMunicipio()
     *
     * Método responsável por editar as informações de um município a partir do seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     * @param $idMunicipio
     * @return JSON $data
     */
    public function editarMunicipio($idMunicipio)
    {
        // Recebendo a requisição via GET
        $data = $this->municipio_model->getIdMunicipio($idMunicipio);

        // Retornando o JSON
        echo json_encode($data);
    }
    /**
     * Fuction atualizarMunicipio()
     *
     * Método responsável por atualizar no DB os dados de um municipio
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return JSON
     */
    public function atualizarMunicipio()
    {
        // Recebendo o ID do municipio que sofrerá a atualização
        $this->municipio_model->atualizarMunicipio(array('idMunicipio' => $this->input->post('idMunicipio')));

        // Retornando o JSON
        echo json_encode(array('status' => TRUE));
    }
    /**
     * Function excluirMonicipio()
     *
     * Método responsavel pela exclusão de um municipio a partir do seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idMunicipio
     */
    public function excluirMunicipio($idMunicipio)
    {
        // Chamada para o método excluirMunicipio a partir do $idMunicipio
        $this->municipio_model->excluirMunicipio($idMunicipio);

        // Retornando ao usuário a informação de exclusão do municipio
        $this->session->set_flashdata('sucessoDelMunicipio','Município excluído com sucesso.');

        // Redirecionando o usuário para a dashboard
        redirect('dashboard/municipios');
    }
}