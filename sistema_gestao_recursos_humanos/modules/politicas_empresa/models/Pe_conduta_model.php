<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_conduta_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_conduta')->num_rows();
        return $query;
    }


    public function create($data) {
        return $this->db->insert('pe_conduta', $data);
    }
    public function get() {
        $query = $this->db->get('pe_conduta');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_conduta', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_conduta');
        return $first;
    }
    public function update ($data, $id) {
        $this->first($id);
        $this->db->where('id', $id);
        $this->db->update('pe_conduta', $data);

        return $this->first($id);
    }
}