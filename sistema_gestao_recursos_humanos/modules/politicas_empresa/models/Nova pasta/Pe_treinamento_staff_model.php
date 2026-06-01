<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_treinamento_staff_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_conduta_treinamento_staff')->num_rows();
        return $query;
    }

    public function create($data) {
        return $this->db->insert('pe_conduta_treinamento_staff', $data);
    }
    public function get($id) {
        $this->db->select('pe_conduta_treinamento_staff.*, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_conduta_treinamento_staff');
        $this->db->join('staff', 'staff.staffid = pe_conduta_treinamento_staff.staff_id', 'left');
        $this->db->join('pe_conduta_treinamento', 'pe_conduta_treinamento.id = pe_conduta_treinamento_staff.conduta_treinamento_id');
        $this->db->where('pe_conduta_treinamento_staff.conduta_treinamento_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function in($id) {
        $this->db->select('staff_id');
        $this->db->from('pe_conduta_treinamento_staff');
        $this->db->where('conduta_treinamento_id', $id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'staff_id');
    }
    public function participantes($id) {
        $ids = $this->in($id);
        $this->db->select('*');
        $this->db->from('staff');
        if ($ids) {
            $this->db->where_not_in('staffid', $ids);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function first($id) {
        $query = $this->db->get_where('pe_conduta_treinamento_staff', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_conduta_treinamento_staff');
        return $first;
    }
    public function update ($data, $id) {
        $this->first($id);
        $this->db->where('id', $id);
        $this->db->update('pe_conduta_treinamento_staff', $data);

        return $this->first($id);
    }
}