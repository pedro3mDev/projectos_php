<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Politica_status_model extends CI_Model
{

  // Nome da tabela
  private $tbl_politica_status = 'tblpl_status ';
  // Função para listar todos os status de políticas
  public function get_all()
  {
    $query = $this->db->get($this->tbl_politica_status);
    return $query->result();
  }

  // Função para pegar um status de política pelo ID
  public function get_by_id($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get($this->tbl_politica_status);
    return $query->row();
  }

  // Função para inserir um novo status de política
  public function insert($data)
  {
    $this->db->insert($this->tbl_politica_status, $data);
    return $this->db->insert_id();
  }

  // Função para atualizar um status de política
  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update($this->tbl_politica_status, $data);
    return $this->db->affected_rows();
  }

  // Função para excluir um status de política
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->tbl_politica_status);
    return $this->db->affected_rows();
  }
}
