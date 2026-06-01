<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Politica_viagem_model extends CI_Model
{
  // Nome da tabela
  private $table = 'tblgv_politica_viagem';

  // Função para pegar todas as políticas de viagem
  public function get_all()
  {
    // Seleciona os campos necessários
    $this->db->select('*');
    $this->db->from($this->table); // Define a tabela
    $query = $this->db->get();
    return $query->result(); // Retorna todas as políticas de viagem encontradas
  }

  // Função para pegar uma política de viagem pelo ID
  public function get_by_id($id)
  {
    // Seleciona os campos necessários
    $this->db->select('*');
    $this->db->from($this->table); // Define a tabela
    $this->db->where('id', $id); // Filtra pela política de viagem com o ID fornecido
    $query = $this->db->get();
    return $query->row_array(); // Retorna uma única política de viagem
  }

  // Função para inserir uma nova política de viagem
  public function insert($data)
  {
    $this->db->insert($this->table, $data); // Insere os dados na tabela
    return $this->db->insert_id(); // Retorna o ID do último registro inserido
  }

  // Função para atualizar uma política de viagem
  public function update($id, $data)
  {
    $this->db->where('id', $id); // Filtra pela política de viagem com o ID fornecido
    $this->db->update($this->table, $data); // Atualiza a política de viagem com os novos dados
    return $this->db->affected_rows(); // Retorna o número de linhas afetadas pela atualização
  }

  // Função para excluir uma política de viagem
  public function delete($id)
  {
    // Verifica se a política de viagem com o ID fornecido existe
    $this->db->where('id', $id);
    $query = $this->db->get($this->table);

    // Se não existir, retorna 0 ou algum valor indicativo
    if ($query->num_rows() == 0) {
      return 0; // Nenhuma política de viagem encontrada com o ID fornecido
    }

    // Se a política de viagem existir, realiza a exclusão
    $this->db->where('id', $id); // Filtra pela política de viagem com o ID fornecido
    $this->db->delete($this->table); // Exclui a política de viagem
    return $this->db->affected_rows(); // Retorna o número de linhas afetadas pela exclusão
  }
}
