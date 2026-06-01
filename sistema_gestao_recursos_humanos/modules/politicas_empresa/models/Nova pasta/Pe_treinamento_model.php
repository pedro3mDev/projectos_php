<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_treinamento_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_conduta_treinamento')->num_rows();
        return $query;
    }

    public function create($data) {
        return $this->db->insert('pe_conduta_treinamento', $data);
    }
    public function get() {
        $this->db->select('pe_conduta_treinamento.*, staff.staffid, staff.firstname, staff.lastname, pe_conduta.nome');
        $this->db->from('pe_conduta_treinamento');
        $this->db->join('staff', 'staff.staffid = pe_conduta_treinamento.staff_id', 'left');
        $this->db->join('pe_conduta', 'pe_conduta.id = pe_conduta_treinamento.conduta_id');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id) {
        $this->db->select('pe_conduta_treinamento.*, staff.staffid, staff.firstname, staff.lastname, pe_conduta.nome');
        $this->db->from('pe_conduta_treinamento');
        $this->db->join('staff', 'staff.staffid = pe_conduta_treinamento.staff_id', 'left');
        $this->db->join('pe_conduta', 'pe_conduta.id = pe_conduta_treinamento.conduta_id');
        $this->db->where('pe_conduta_treinamento.id', $id);
        $query = $this->db->get()->row_array();

        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_conduta_treinamento');
        return $first;
    }
    public function update ($data, $id) {
        $this->first($id);
        $this->db->where('id', $id);
        $this->db->update('pe_conduta_treinamento', $data);

        return $this->first($id);
    }
}