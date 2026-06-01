<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_revisao_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pe_politica_empresa_model');
        $this->load->model('Pe_politica_model');
        $this->load->model('Pe_tipo_politica_model');
        $this->load->model('Pe_categoria_model');
        $this->load->model('Pe_area_model');
        $this->load->model('Pe_status_model');
        $this->load->model('Pe_nivel_hierarquico_model');
    }
    public function total()
    {
        $query = $this->db->get('pe_revisao')->num_rows();
        return $query;
    }
    public function create($data)
    {
        $this->Pe_politica_model->first($data['politica_id']);
        return $this->db->insert('pe_revisao', $data);
    }

    public function get()
    {
        $this->db->select('
            pe_revisao.*,
            staff.firstname, staff.lastname,
            pe_politica.titulo
        ');
        $this->db->from('pe_revisao');
        $this->db->join('staff', 'staff.staffid = pe_revisao.staff_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_revisao.politica_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id)
    {
        $this->db->select('
            pe_revisao.*,
            staff.firstname, staff.lastname,
            pe_politica.titulo
        ');
        $this->db->from('pe_revisao');
        $this->db->join('staff', 'staff.staffid = pe_revisao.staff_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_revisao.politica_id', 'left');
        $this->db->where('pe_revisao.id', $id);

        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update($data, $id)
    {
        $this->first($id);
        $this->Pe_politica_model->first($data['politica_id']);

        $this->db->where('id', $id);
        $this->db->update('pe_revisao', $data);

        return $this->first($id);
    }
    public function aprovar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_revisao', $data);

        return $this->first($id);
    }
    public function rejeitar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_revisao', $data);

        return $this->first($id);
    }
    public function delete($id)
    {
        $first = $this->first($id);
        $this->db->where('id', $id);
        $this->db->delete('pe_revisao');
        return $first;
    }
}