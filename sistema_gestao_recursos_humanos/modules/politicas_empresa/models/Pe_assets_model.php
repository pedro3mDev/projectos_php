<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_assets_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_assets')->num_rows();
        return $query;
    }
    public function create($data) {
        return $this->db->insert('pe_assets', $data);
    }
    public function get()
    {
        $this->db->select('pe_assets.*, pe_categoria_assets.categoria, pe_fornecedor.nome as fornecedor, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_assets');
        $this->db->join('staff', 'staff.staffid = pe_assets.staff_id');
        $this->db->join('pe_categoria_assets', 'pe_categoria_assets.id = pe_assets.categoria_assets_id');
        $this->db->join('pe_fornecedor', 'pe_fornecedor.id = pe_assets.fornecedor_id');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id) {
        // $query = $this->db->get_where('pe_assets', ['id' => $id])->row_array();
        $this->db->select('pe_assets.*, pe_categoria_assets.categoria, pe_fornecedor.nome as fornecedor, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_assets');
        $this->db->join('staff', 'staff.staffid = pe_assets.staff_id');
        $this->db->join('pe_categoria_assets', 'pe_categoria_assets.id = pe_assets.categoria_assets_id');
        $this->db->join('pe_fornecedor', 'pe_fornecedor.id = pe_assets.fornecedor_id');
        $this->db->where('pe_assets.id', $id);
        $query = $this->db->get()->row_array();

        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $vfcategoria = $this->first($id);
        $this->db->where('id', $id);
        $this->db->update('pe_assets', $data);

        return $this->first($id);
    }
    public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_assets');
        return $first;
    }
}