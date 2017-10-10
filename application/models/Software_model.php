<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Software_model
 *
 * Classe responsável pela interação com a tabela softwere
 */
class Software_model extends CI_Model
{
    private $dataPublicacao;
    private $ultimaAtualizacao;
    /*
     |------------------------------------------------------------------------
     | Métodos acessórios
     |------------------------------------------------------------------------
     |
     | Métodos utilizados em outros controllers para recuperar informações,
     | validações e outras ferramentas necessárias ao funcionamento do app.
     |
     | - getAllSoftwares:       recupera todos os softwares catalogados
     | - getSotwareById:        recupera os dados de um software a partir do seu
     |                          ID e o responsável pelo cadastro
     | - getIdSoftware:         recupera os dados de um software a partir do seu
     |                          ID e permite a sua edição
     | - countSoftwaresByArea:  Conta os softwares a partir de sua área
     | - countSoftwares:        Conta os softwares cadastrados o sistema
     |
     |------------------------------------------------------------------------
     */
    /**
     * Function getAllSoftwares()
     *
     * Método responsável para retornar todos os softwares catalogados no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return $query array
     */
    public function getAllSoftwares()
    {
        // Recuperando todos os dados dos softwares catalogados
        $this->db->select('p.idPrograma, p.nomeSoftware, u.nomeUsuario, p.criadoEm');
        $this->db->from('programas p');
        $this->db->join('usuarios u','responsavelCadastro = idUsuario');
        $this->db->order_by('criadoEm','DESC');
        $query = $this->db->get();

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /**
     * Function getSoftwareById()
     *
     * Método responsável por buscar um software a partir do seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     * @param $idPrograma
     * @return mixed
     */
    public function getSotwareById($idPrograma)
    {
        // Recuperando os dados do software selecinado a partir do seu ID
        $this->db->select('p.idPrograma, p.nomeSoftware, p.descricaoSoftware, p.requerimentoMemoria, p.requerimentoProcessador,
        p.requerimentoDisco, p.requerimentoSoftware, p.requerimentoLinguagem, DATE_FORMAT(p.dataPublicacao, "%d/%c/%Y") as dataPublicacao,
        DATE_FORMAT(p.ultimaAtualizacao, "%d/%c/%Y") as ultimaAtualizacao, a.descricaoArea, p.siteSoftware, p.manualSoftware,
        p.observacoes, u.nomeUsuario, DATE_FORMAT(p.criadoEm, "%d/%c/%Y") as criadoEm, DATE_FORMAT(p.criadoEm, "%H:%i") as horaCriacao');
        $this->db->from('programas p');
        $this->db->join('areaSoftwares a', 'p.areaSoftware = a.idAreaSoftware');
        $this->db->join('usuarios u', 'p.responsavelCadastro = u.idUsuario');
        $this->db->where('idPrograma', $idPrograma);
        $query = $this->db->get();

        // Retornando a linha selecionada
        return $query->row();
    }
    /**
     * Function getIdSoftware
     *
     * Método responsavel por buscar as informações de um software para ediçao a partir de seu ID
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idPrograma
     * @return mixed
     */
    public function getIdSoftware($idPrograma)
    {
        // Selecionando os campos para exibição e formatando as saídas
        $this->db->select('*, DATE_FORMAT(dataPublicacao, "%d/%c/%Y") as formatDataPublicacao, DATE_FORMAT(ultimaAtualizacao, "%d/%c/%Y") as formatUltimaAtualizacao');

        // Recuperando o registro do software no DB a partir de ID
        $query = $this->db->get_where('programas', array('idPrograma' => $idPrograma));

        // Retonando a linha relativa ao municipio
        return $query->row();
    }
    /**
     * Function countSoftwareByArea()
     *
     * Método responsavel por contar os softwares cadastrados por area
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     * @return mixed
     */
    public function countSoftwaresByArea()
    {
        // Contando os regisrtros de cada software a partir de sua area
        $query = $this->db->query('select areaSoftware,
        (select count(idPrograma) from programas where areaSoftware = 1) as saude,
        (select count(idPrograma) from programas where areaSoftware = 2) as educacao,
        (select count(idPrograma) from programas where areaSoftware = 3) as patrimonio,
        (select count(idPrograma) from programas where areaSoftware = 4) as execucao,
        (select count(idPrograma) from programas where areaSoftware = 5) as folhaPagamento,
        (select count(idPrograma) from programas where areaSoftware = 6) as cadastroFuncionarios
        from programas');

        // Retornando o array com a contagem dos softwares por area
        return $query->row_array();
    }
    /**
     * Function countSoftwares()
     *
     * Método responsável pela contagem de softwares cadatrados no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @return array
     */
    public function countSoftwares()
    {
        // Contando softwares no DB
        $query = $this->db->count_all('programas');

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
     * Function criarSoftware()
     *
     * Método responsável pela inserção de um novo software no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     */
    public function criarSoftware()
    {
        // Realizando o tratamento da data para inserção no DB
        $dataPublicacaoMysql = explode('/', $_POST['dataPublicacao']);
        $ultimaAtualizacaoMysql = explode('/', $_POST['ultimaAtualizacao']);

        // Recebendo os dados obtidos a partir do formulário de criação de software
        $dataSoftware = array(
            'nomeSoftware'              => $_POST['nomeSoftware'],
            'descricaoSoftware'         => $_POST['descricaoSoftware'],
            'requerimentoMemoria'       => $_POST['requerimentoMemoria'],
            'requerimentoProcessador'   => $_POST['requerimentoProcessador'],
            'requerimentoDisco'         => $_POST['requerimentoDisco'],
            'requerimentoSoftware'      => $_POST['requerimentoSoftware'],
            'requerimentoLinguagem'     => $_POST['requerimentoLinguagem'],
            'dataPublicacao'            => $this->dataPublicacao = "$dataPublicacaoMysql[2]-$dataPublicacaoMysql[1]-$dataPublicacaoMysql[0]",
            'ultimaAtualizacao'         => $this->ultimaAtualizacao = "$ultimaAtualizacaoMysql[2]-$ultimaAtualizacaoMysql[1]-$ultimaAtualizacaoMysql[0]",
            'areaSoftware'              => $_POST['areaSoftware'],
            'siteSoftware'              => $_POST['siteSoftware'],
            'manualSoftware'            => $_POST['manualSoftware'],
            'observacoes'               => $_POST['observacoes'],
            'responsavelCadastro'       => $_POST['responsavelCadastro'],
            'criadoEm'                  => date('Y-m-d H:i:s')
        );

        // Realizando o insert no DB
        $this->db->insert('programas', $dataSoftware);
    }
    /**
     * Function atualizarSoftware()
     *
     * Método responsável pela atualização de um software no DB
     *
     * @since 1.0
     * @author Renato Bonfim Jr
     * @param $idPrograma
     */
    public function atualizarSoftware($idPrograma)
    {
        // Realizando o tratamento da data para inserção no DB
        $dataPublicacaoMysql = explode('/', $_POST['editarDataPublicacao']);
        $ultimaAtualizacaoMysql = explode('/', $_POST['editarUltimaAtualizacao']);

        // Recebendo os dados obtidos a partir do formulário de criação de software
        $dataSoftware = array(
            'nomeSoftware'              => $_POST['editarNomeSoftware'],
            'descricaoSoftware'         => $_POST['editarDescricaoSoftware'],
            'requerimentoMemoria'       => $_POST['editarRequerimentoMemoria'],
            'requerimentoProcessador'   => $_POST['editarRequerimentoProcessador'],
            'requerimentoDisco'         => $_POST['editarRequerimentoDisco'],
            'requerimentoSoftware'      => $_POST['editarRequerimentoSoftware'],
            'requerimentoLinguagem'     => $_POST['editarRequerimentoLinguagem'],
            'dataPublicacao'            => $this->dataPublicacao = "$dataPublicacaoMysql[2]-$dataPublicacaoMysql[1]-$dataPublicacaoMysql[0]",
            'ultimaAtualizacao'         => $this->ultimaAtualizacao = "$ultimaAtualizacaoMysql[2]-$ultimaAtualizacaoMysql[1]-$ultimaAtualizacaoMysql[0]",
            'areaSoftware'              => $_POST['editarAreaSoftware'],
            'siteSoftware'              => $_POST['editarSiteSoftware'],
            'manualSoftware'            => $_POST['editarManualSoftware'],
            'observacoes'               => $_POST['editarObservacoes'],
            'responsavelEdicao'         => $_POST['responsavelEdicao'],
            'editadoEm'                 => date('Y-m-d H:i:s')
        );

        // Atualizando o registro do software
        $this->db->update('programas', $dataSoftware, $idPrograma);

        // Retornando os dados modificados
        return $this->db->affected_rows();
    }
    /**
     * Function excluirSoftware()
     *
     * Método responsável pela exclusão de um software
     *
     * @since 1.0
     * @author Renato Bonfim Jr.
     * @param $idPrograma
     */
    public function excluirSoftware($idPrograma)
    {
        // Excluindo o software correspondente
        $this->db->delete('programas', array('idPrograma' => $idPrograma));
    }
}