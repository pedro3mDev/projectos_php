<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Despesas_model extends CI_Model
{

    protected $table = 'tblgv_despesas';

    // Retorna todas as despesas
    public function get_all()
    {
        return $this->db->get($this->table)->result_array();
    }

    // Retorna uma despesa por ID
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    // Insere uma nova despesa
    public function insert($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();  // Retorna o ID da última inserção
        }
        return FALSE;  // Caso a inserção falhe
    }

    // Atualiza uma despesa por ID
    public function update($id, $data)
    {
        if ($this->db->update($this->table, $data, ['id' => $id])) {
            return TRUE;  // Atualização bem-sucedida
        }
        return FALSE;  // Falha na atualização
    }

    // Exclui uma despesa por ID
    public function delete($id)
    {
        // Verifica se a despesa existe
        $despesa = $this->get_by_id($id);
        if (empty($despesa)) {
            // Retorna FALSE ou um código de erro caso a despesa não exista
            return FALSE;  // Despesa não encontrada
        }

        // Tenta excluir a despesa
        if ($this->db->delete($this->table, ['id' => $id])) {
            return TRUE;  // Exclusão bem-sucedida
        }

        return FALSE;  // Falha na exclusão
    }
}
