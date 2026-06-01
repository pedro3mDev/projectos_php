<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_localizacao_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_localizacao_assets')->num_rows();
        return $query;
    }
    public function create($data) {
        $vfCategoria = $this->db->get_where('pe_localizacao_assets', [
                'descricao' => $data['descricao'],
                'localizacao' => $data['localizacao'],
        ])->row_array();
        if ($vfCategoria) {
            set_alert('danger',"Localização já foi cadastrada");
			redirect('politicas_empresa/politicas_assets/nova_localizacao');
        }
        return $this->db->insert('pe_localizacao_assets', $data);
    }
    public function get() {
        $query = $this->db->get('pe_localizacao_assets');
        return $query->result_array();
    }
    public function first($id) {
        $this->db->select('pe_localizacao_assets.*, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_localizacao_assets');
        $this->db->join('staff', 'staff.staffid = pe_localizacao_assets.staff_id', 'right');
        $this->db->where('pe_localizacao_assets.id', $id);

        $query = $this->db->get()->row_array();

        // $query = $this->db->get_where('pe_categoria', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfLoc = $this->db->get_where('pe_localizacao_assets', [
            'descricao' => $data['descricao'],
            'localizacao' => $data['localizacao'],
        ])->row_array();
        if ($vfLoc) {
            if ($id != $vfLoc['id']) {
                set_alert('danger',"Fornecedor já foi cadastrada");
			    redirect('politicas_empresa/politicas_assets/fornecedor_editar/'.$id);
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_localizacao_assets', $data);

        return $this->first($id);
    }public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_localizacao_assets');
        return $first;
    }
}