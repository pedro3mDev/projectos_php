<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Politica_model extends CI_Model
{

    // Nome da tabela
    private $tbl_politica = 'tblpl_politicas_empresas ';

    // Função para pegar todas as políticas
    // Função para pegar todas as políticas
    public function get_all()
    {
        $this->db->select('p.*, s.nome as status_nome');
        // Descomente e ajuste se precisar incluir o nome do funcionário
        // $this->db->select('p.*, s.nome as status_nome, f.nome as funcionario_nome');
        $this->db->from($this->tbl_politica . ' p');
        $this->db->join('tblpl_status s', 's.id = p.status_id');
        // Descomente e ajuste se precisar fazer o join com a tabela de funcionários
        // $this->db->join('tblpl_funcionarios f', 'f.id = p.funcionario_id');
        $query = $this->db->get();
        return $query->result();  // Retorna todas as políticas encontradas
    }

    // Função para pegar uma política pelo ID
    public function get_by_id($id)
    {
        // $this->db->select('p.*, s.nome as status_nome, f.nome as funcionario_nome');
        $this->db->select('p.*, s.nome as status_nome');
        $this->db->from($this->tbl_politica . ' p');
        // Descomente e ajuste se precisar fazer o join com a tabela de funcionários
        $this->db->join('tblpl_status s', 's.id = p.status_id');
        // $this->db->join('tblpl_funcionarios f', 'f.id = p.funcionario_id');
        $this->db->where('p.id', $id);  // Filtra a política pelo ID
        $query = $this->db->get();
        return $query->row();  // Retorna uma única política
    }

    // Função para inserir uma nova política
    public function insert($data)
    {
        $this->db->insert($this->tbl_politica, $data);  // Insere os dados na tabela
        return $this->db->insert_id();  // Retorna o ID do último registro inserido
    }

    // Função para atualizar uma política
    public function update($id, $data)
    {
        $this->db->where('id', $id);  // Filtra pela política com o ID fornecido
        $this->db->update($this->tbl_politica, $data);  // Atualiza a política com os novos dados
        return $this->db->affected_rows();  // Retorna o número de linhas afetadas pela atualização
    }

    // Função para excluir uma política
    public function delete($id)
    {
        // Verifica se a política com o ID fornecido existe
        $this->db->where('id', $id);
        $query = $this->db->get($this->tbl_politica);
    
        // Se não existir, retorna 0 ou algum valor indicativo
        if ($query->num_rows() == 0) {
            return 0;  // Nenhuma política encontrada com o ID fornecido
        }
    
        // Se a política existir, realiza a exclusão
        $this->db->where('id', $id);  // Filtra pela política com o ID fornecido
        $this->db->delete($this->tbl_politica);  // Exclui a política
        return $this->db->affected_rows();  // Retorna o número de linhas afetadas pela exclusão
    }
    
}
