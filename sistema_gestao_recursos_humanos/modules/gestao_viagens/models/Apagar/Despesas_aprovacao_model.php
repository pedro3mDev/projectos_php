<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Despesas_aprovacao_model extends CI_Model
{

    protected $table = 'tblgv_despesa_decisao';

    // Retorna todas as aprovações de despesas
    public function get_all()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();  // Retorna o ID do último registro inserido
        }
        return FALSE;  // Caso a inserção falhe
    }

    public function update($id, $data)
    {
        if ($this->get_by_id($id)) {  // Verifica se o registro existe
            return $this->db->update($this->table, $data, ['id' => $id]);
        }
        return FALSE;  // Caso o registro não exista
    }

    public function delete($id)
    {
        if ($this->get_by_id($id)) {  // Verifica se o registro existe
            return $this->db->delete($this->table, ['id' => $id]);
        }
        return FALSE;  // Caso o registro não exista
    }
}
