<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_fornecedor_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_fornecedor')->num_rows();
        return $query;
    }
    public function create($data) {
        $vfCategoria = $this->db->get_where('pe_fornecedor', ['nome' => $data['nome']])->row_array();
        if ($vfCategoria) {
            set_alert('danger',"Fornecedor já foi cadastrada");
			redirect('politicas_empresa/politicas_assets/novo_fornecedor');
        }
        return $this->db->insert('pe_fornecedor', $data);
    }
    public function get() {
        $query = $this->db->get('pe_fornecedor');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_fornecedor', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfFornecedor = $this->db->get_where('pe_fornecedor', ['nome' => $data['nome']])->row_array();
        if ($vfFornecedor) {
            if ($id != $vfFornecedor['id']) {
                set_alert('danger',"Fornecedor já foi cadastrada");
			    redirect('politicas_empresa/politicas_assets/fornecedor_editar/'.$id);
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_fornecedor', $data);

        return $this->first($id);
    }public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_fornecedor');
        return $first;
    }
}