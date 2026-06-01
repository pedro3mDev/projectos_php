<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_categoria_assets_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_categoria_assets')->num_rows();
        return $query;
    }

    public function create($data) {
        $vfCategoria = $this->db->get_where('pe_categoria_assets', ['categoria' => $data['categoria']])->row_array();
        if ($vfCategoria) {
            set_alert('danger',"Categoria já foi cadastrada");
			redirect('politicas_empresa/politicas_assets/nova_categoria');
        }
        return $this->db->insert('pe_categoria_assets', $data);
    }
    public function get() {
        $query = $this->db->get('pe_categoria_assets');
        return $query->result_array();
    }
    public function first($id) {
        $this->db->select('pe_categoria_assets.*, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_categoria_assets');
        $this->db->join('staff', 'staff.staffid = pe_categoria_assets.staff_id', 'right');
        $this->db->where('pe_categoria_assets.id', $id);

        $query = $this->db->get()->row_array();

        // $query = $this->db->get_where('pe_categoria_assets', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }

    public function update ($data, $id) {
        $vfcategoria = $this->first($id);
        $vfcatedit = $this->db->get_where('pe_categoria_assets', ['categoria' => $data['categoria']])->row_array();
        if ($vfcatedit) {
            if ($id != $vfcatedit['id']) {
                set_alert('danger',"Categoria já foi cadastrada");
			    redirect('politicas_empresa/politicas_assets/categoria/'.$id);
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_categoria_assets', $data);

        return $this->first($id);
    }
    public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_categoria_assets');
        return $first;
    }
}