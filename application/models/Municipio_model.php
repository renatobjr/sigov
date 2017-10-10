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
     | - getAllMunicipios:  recupera todos os municipios cadastrados
     | - getMunicipioById:  recupera os dados de um municipio a partir do seu
     |                      ID e o responsável pelo cadastro
     | - getIdMunicipio:    recupera os dados de um municipio a partir do seu
     |                      ID e permite a sua edição
     | - countMunicipios:   conta o total de municipios cadastrados no sistema
     |
     |------------------------------------------------------------------------
     */
    /**
     * Fuction getAllMunicipios()
     *
     * Método responsável por trazer todos os municipios cadastrados
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return $query array
     */
    public function getAllMunicipios()
    {
        // Recuperando todos os dados dos municipios cadastrados
        $this->db->select('m.idMunicipio, m.nomeMunicipio, m.densidadeDemografica, m.pibPerCapta, m.sistemaSaude, 
        m.sistemaEducacao, m.sistemaPatrimonio, m.sistemaExecucao, m.sistemaFolhaPagamento, m.sistemaFuncionarios, u.nomeUsuario, m.criadoEm');
        $this->db->join('usuarios u', 'responsavelCadastro = idUsuario');
        $this->db->order_by('criadoEm', 'DESC');
        $query = $this->db->get('municipios m', 30);

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /**
     * Fuction getMunicipioById()
     *
     * Método responsável por retornar um municipio a partir do seu ID utilizando um SQL JOIN para informar o nome do
     * pesquisador que realizou o cadastro
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idMunicipio
     * @return $query array
     */
    public function getMunicipioById($idMunicipio)
    {
        // Recuperando os dados do municipio selecinado a partir do seu ID
        $this->db->select('m.idMunicipio, m.nomeMunicipio, FORMAT(m.densidadeDemografica,2,"de_DE") as densidadeDemografica, 
        FORMAT(m.pibPerCapta,2,"de_DE") as pibPerCapta, m.sistemaSaude, m.sistemaEducacao, m.sistemaPatrimonio, 
        m.sistemaExecucao, m.sistemaFolhaPagamento, m.sistemaFuncionarios, u.nomeUsuario, DATE_FORMAT(m.criadoEm, "%d/%c/%Y") 
        as criadoEm, DATE_FORMAT(m.criadoEm, "%H:%i") as horaCriacao');
        $this->db->from('municipios m');
        $this->db->join('usuarios u', 'responsavelCadastro = idUsuario');
        $this->db->where('idMunicipio', $idMunicipio);
        $query = $this->db->get();

        // Retornando a linha selecionada
        return $query->row();
    }
    /**
     * Fuction getIdMunicipio()
     *
     * Método responsável por recuperar os dados de um municipio a partir do seu ID e permite a sua edição
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idMunicipio
     * @return $query array
     */
    public function getIdMunicipio($idMunicipio)
    {
        // Selecionando campos para atualização
        $this->db->select('idMunicipio, nomeMunicipio, FORMAT(densidadeDemografica,2,"de_DE") as densidadeDemografica, FORMAT(pibPerCapta,2,"de_DE") as pibPerCapta, sistemaSaude, sistemaEducacao, sistemaPatrimonio, sistemaExecucao, sistemaFolhaPagamento, sistemaFuncionarios');

        // Recuperando o registro do municipio no DB a partir de ID
        $query = $this->db->get_where('municipios', array('idMunicipio' => $idMunicipio));

        // Retonando a linha relativa ao municipio
        return $query->row();
    }
    /**
     * Function countMunicipios()
     *
     * Método responsável pela contagem de municipios cadatrados no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return array
     */
    public function countMunicipios()
    {
        // Contando municipios no DB
        $query = $this->db->count_all('municipios');

        // Retornado o valor da contagem
        return $query;
    }
    /*
     |------------------------------------------------------------------------
     | Métodos principais do Model
     |------------------------------------------------------------------------
     |
     | Métodos utilizados exclusivamente pelo controller Municipio
     |------------------------------------------------------------------------
     */
    /**
     * Function criarMunicipio()
     *
     * Métodos responsável por adicionar um municipio ao DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
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

        // Tratando os campos com formato numerico
        $this->densidadeDemografica->str_replace(',','.',$_POST['densidadeDemografica']);
        $this->pibPerCapta->str_replace(',','.',str_replace('.','',$_POST['pibPerCapta']));

        // Recebendo os dados obtidos a partir do formulário de criação de municipios
        $dataMunicipio = array(
            'nomeMunicipio'         => $_POST['nomeMunicipio'],
            'densidadeDemografica'  => $this->densidadeDemografica,
            'pibPerCapta'           => $this->pibPerCapta,
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
    /**
     * Fuction atualizarMunicipio()
     *
     * Método responsável por atualizar um municipio utilizando uma requisição Ajax
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idMunicipio
     * @return array
     */
    public function atualizarMunicipio($idMunicipio)
    {
        // Recebendo os dados obtidos a partir do formulário de edição de municipios
        $dataMunicipio = array(
            'nomeMunicipio'         => $_POST['editarNomeMunicipio'],
            'densidadeDemografica'  => str_replace(',','.',$_POST['editarDensidadeDemografica']),
            'pibPerCapta'           => str_replace(',','.',str_replace('.','',$_POST['editarPibPerCapta'])),
            'sistemaSaude'          => isset($_POST['editarSistemaSaude']) ? 1 : 0,
            'sistemaEducacao'       => isset($_POST['editarSistemaEducacao']) ? 1 : 0,
            'sistemaPatrimonio'     => isset($_POST['editarSistemaPatrimonio']) ? 1 : 0,
            'sistemaExecucao'       => isset($_POST['editarSistemaExecucao']) ? 1 : 0,
            'sistemaFolhaPagamento' => isset($_POST['editarSistemaFolhaPagamento']) ? 1 : 0,
            'sistemaFuncionarios'   => isset($_POST['editarSistemaFuncionarios']) ? 1 : 0,
            'responsavelEdicao'     => $_POST['responsavelEdicao'],
            'editadoEm'             => date('Y-m-d H:i:s')
        );

        // Atualizando o registro do municipio
        $this->db->update('municipios', $dataMunicipio, $idMunicipio);

        // Retornando os dados modificados
        return $this->db->affected_rows();
    }
    /**
     * Fuction excluirMunicipio()
     *
     * Método responsável plor excluir um municipio a partir do seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idMunicipio
     */
    public function excluirMunicipio($idMunicipio)
    {
        // Excluindo o municipio correspondente
        $this->db->delete('municipios', array('idMunicipio' => $idMunicipio));
    }
}