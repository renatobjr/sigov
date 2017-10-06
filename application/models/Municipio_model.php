<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Municipio_model
 *
 * Classe responsável pela interação com a tabela municipios
 */
class Municipio_model extends CI_Model
{
    private $idMunicipio;
    private $nomeMunicipio;
    private $densidadeDemografica;
    private $pibPerCapta;
    private $sistemaSaude;
    private $sistemaEducacao;
    private $sistemaPatrimonio;
    private $sistemaExecucao;
    private $sistemaFolhaPagamento;
    private $sistemaFuncionarios;
    private $responsavelCadastro;
    private $criadoEm;
    private $responsavelEdicao;
    private $editadoEm;
    /*
     |------------------------------------------------------------------------
     | Métodos acessórios
     |------------------------------------------------------------------------
     |
     | Métodos utilizados em outros controllers para recuperar informações,
     | validações e outras ferramentas necessárias ao funcionamento do app.
     |
     |
     |------------------------------------------------------------------------
     */
    public function getAllMunicipios()
    {
        // Recuperando todos os dados dos municipios cadastrados
        $this->db->select('m.idMunicipio, m.nomeMunicipio, m.densidadeDemografica, m.pibPerCapta, m.sistemaSaude, m.sistemaEducacao, m.sistemaPatrimonio, m.sistemaExecucao, m.sistemaFolhaPagamento, m.sistemaFuncionarios, u.nomeUsuario, m.criadoEm');
        $this->db->from('municipios m');
        $this->db->join('usuarios u', 'responsavelCadastro = idUsuario');
        $this->db->order_by('criadoEm', 'DESC');
        $query = $this->db->get();

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /*
     |------------------------------------------------------------------------
     | Métodos principais do Model
     |------------------------------------------------------------------------
     |
     | Métodos utilizados exclusivamente pelo controller Municipio
     |------------------------------------------------------------------------
     */
    public function criarMunicipio()
    {
        // Tratando checkboxes evitando entradas inconsistentes
        $this->sistemaSaude             = (isset($_POST['sistemaSaude']) ? 1 : 0);
        $this->sistemaEducacao          = (isset($_POST['sistemaEducacao']) ? 1 : 0);
        $this->sistemaPatrimonio        = (isset($_POST['sistemaPatrimonio']) ? 1 : 0);
        $this->sistemaExecucao          = (isset($_POST['sistemaExecucao']) ? 1 : 0);
        $this->sistemaFolhaPagamento    = (isset($_POST['sistemaFolhaPagamento']) ? 1 : 0);
        $this->sistemaFuncionarios      = (isset($_POST['sistemaFuncionarios']) ? 1 : 0);

        // Recebendo os dados obtidos a partir do formulário de criação de municipios
        $dataMunicipio = array(
            'nomeMunicipio'         => $_POST['nomeMunicipio'],
            'densidadeDemografica'  => $_POST['densidadeDemografica'],
            'pibPerCapta'           => $_POST['pibPerCapta'],
            'sistemaSaude'          => $this->sistemaSaude,
            'sistemaEducacao'       => $this->sistemaEducacao,
            'sistemaPatrimonio'     => $this->sistemaPatrimonio,
            'sistemaExecucao'       => $this->sistemaExecucao,
            'sistemaFolhaPagamento' => $this->sistemaFolhaPagamento,
            'sistemaFuncionarios'   => $this->sistemaFuncionarios,
            'responsavelCadastro'   => $_POST['responsavelCadastro'],
            'criadoEm'              => date('Y-m-d H:i:s')
        );

        // Realizando o insert no DB
        $this->db->insert('municipios', $dataMunicipio);
    }
}