<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Municipio_model
 *
 * Classe responsável pela interação com a tabela municipios
 */
class Municipio_model extends CI_Model
{
    /**
     * Variáveis globais referentes aos campos da tabela usuarios
     */
    private $idMunicipio;

    /*
     |------------------------------------------------------------------------
     | Métodos acessórios
     |------------------------------------------------------------------------
     |
     | Métodos utilizados em outros controllers para recuperar informações,
     | validações e outras ferramentas necessárias ao funcionamento do app.
     |
     | - getAllMunicipios:  recupera os dados de todos os municipios cadastrados
     | - countMunicipio:    recupera a quantidade de municipios cadastrados
     | 
     |------------------------------------------------------------------------
     */
    /**
     * Function getAllMunicipios()
     *
     * Método responsável pela recuperação de todos os registros de municipios no DB
     *
     * @since 1.0
     * @author Naamã Lima
     * @return array $query
     */
    public function getAllMunicipios()
    {
        // Recuperando todos os registro relativos a municipios no DB
        $query = $this->db->get('municipios');

        // Retornando o array com os dados de todos os registros
        return $query->result_array();
    }
    /**
     * Function countMunicipios()
     *
     * Método responsável pela recuperação da quantidade de registros na tabela municipios
     *
     * @since 1.0
     * @author Naamã Lima
     * @return array $query
     */

    public function countMunicipios()
    {
        // Recuperando a quantidade de registros na tabela municipios
        $query = $this->db->count_all_results('municipios');

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
    
    /**
     * Function criarMunicipio()
     *
     * Método utilizado pelo controller Municipio para realizar o processo de inserção de municípios no DB
     *
     * @since 1.0
     * @author Naamã Lima
     * @return array $dataMunicipio
     */
    public function criarMunicipio()
    {
        // Recebendo os dados obtidos a partir do formulário de criação de município
        $dataMunicipio = array(
            'nomeMunicipio'             => $_POST['nomeMunicipio'],
            'densidadeDemografica'      => $_POST['densidadeDemografica'],
            'densidadePopulacional'     => $_POST['densidadePopulacional'],
            'arrecadacaoTributo'        => $_POST['arrecadacaoTributo'],
            'sistemaSaude'              => $_POST['sistemaSaude'],
            'sistemaEducacao'           => $_POST['sistemaEducacao'],
            'sistemaPatrimonio'         => $_POST['sistemaPatrimonio'],
            'sistemaExecucao'           => $_POST['sistemaExecucao'],
            'sistemaFolhaPagamento'     => $_POST['sistemaFolhaPagamento'],
            'sistemaFuncionarios'       => $_POST['sistemaFuncionarios'],
            'responsavelCadastro'       => $_POST['responsavelCadastro'],
            'criadoEm'                  => $_POST['criadoEm'],
            'responsavelEdicao'         => $_POST['responsavelEdicao'],
            'editadoEm'                 => $_POST['editadoEm']
        );

        // Realizando o Insert no DB
        $query = $this->db->insert('municipios',$dataMunicipio);

        // Retornando os dados do municipio.
        if($query)
            return $dataMunicipio;
    }

    /**
     * Function atualizarMunicipio()
     *
     * Método responsável por realizar a atualização dos dados do municipio a partir da requisiaçao Ajax
     *
     * @since 1.0
     * @author Naamã Lima
     * @param $idMunicipio
     * @return mixed
     */
    public function atualizarMunicipio($idMunicipio)
    {
        // Recebendo os dados obtidos a partir do formulário de atualização do municipio
        $dataMunicipio = array(
            'nomeMunicipio'             => $_POST['nomeMunicipio'],
            'densidadeDemografica'      => $_POST['densidadeDemografica'],
            'densidadePopulacional'     => $_POST['densidadePopulacional'],
            'arrecadacaoTributo'        => $_POST['arrecadacaoTributo'],
            'sistemaSaude'              => $_POST['sistemaSaude'],
            'sistemaEducacao'           => $_POST['sistemaEducacao'],
            'sistemaPatrimonio'         => $_POST['sistemaPatrimonio'],
            'sistemaExecucao'           => $_POST['sistemaExecucao'],
            'sistemaFolhaPagamento'     => $_POST['sistemaFolhaPagamento'],
            'sistemaFuncionarios'       => $_POST['sistemaFuncionarios'],
            'responsavelCadastro'       => $_POST['responsavelCadastro'],
            'criadoEm'                  => $_POST['criadoEm'],
            'responsavelEdicao'         => $_POST['responsavelEdicao'],
            'editadoEm'                 => $_POST['editadoEm']
        );

        // Atualizando o registro do municipio
        $this->db->update('municipios', $dataMunicipio, $idMunicipio);

        // Retornando os dados modificados
        return $this->db->affected_rows();
    }

    /**
     * Fuction excluirMunicipio()
     *
     * Método responsável por excluir um municipio a partir do seu ID, excluindo resgistros criados pelo mesmo
     *
     * @since 1.0
     * @author Naamã Lima
     * @param $idMunicipio
     */
    public function excluirMunicipio($idMunicipio)
    {
        // Definindo o campo que serve de parametro para a idMunicipio e excluindo
        $this->db->delete('municipios', array('idMunicipio' => $idMunicipio));
    }
}