<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planeamento_model extends CI_Model
{

    protected $table = 'tblgv_planeamento';

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

    // Insere uma nova
    public function insert($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();  // Retorna o ID da última inserção
        }
        return FALSE;  // Caso a inserção falhe
    }

    public function update($id, $data)
    {
        if ($this->db->update($this->table, $data, ['id' => $id])) {
            return TRUE;  // Atualização bem-sucedida
        }
        return FALSE;  // Falha na atualização
    }

    // Exclui uma por ID
    public function delete($id)
    {
        // Verifica se a existe
        $planeamento = $this->get_by_id($id);
        if (empty($planeamento)) {
            // Retorna FALSE ou um código de erro caso não exista
            return FALSE;  //  não encontrada
        }

        // Tenta excluir a despesa
        if ($this->db->delete($this->table, ['id' => $id])) {
            return TRUE;  // Exclusão bem-sucedida
        }

        return FALSE;  // Falha na exclusão
    }
}
