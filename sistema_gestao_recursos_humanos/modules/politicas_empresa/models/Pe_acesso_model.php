<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_acesso_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_acesso')->num_rows();
        return $query;
    }
    public function create($data) {
        return $this->db->insert('pe_acesso', $data);
    }
    public function get($id)
    {
        $this->db->select('pe_acesso.*, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_acesso');
        $this->db->join('staff', 'staff.staffid = pe_acesso.staff_id');
        $this->db->where('pe_acesso.politica_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function get_all()
    {
        $this->db->select('pe_acesso.*, staff.staffid, staff.firstname, staff.lastname, pe_politica.titulo');
        $this->db->from('pe_acesso');
        $this->db->join('staff', 'staff.staffid = pe_acesso.staff_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_acesso.politica_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function first($id) {
        $query = $this->db->get_where('pe_acesso', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
}