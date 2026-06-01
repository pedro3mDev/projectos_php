<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_manutencao_model extends CI_Model
{
    public function __construct() {
		parent::__construct();
		$this->load->model('Pe_assets_model');
		$this->load->model('Pe_ciclo_vida_model');
	}
    public function total() {
        $query = $this->db->get('pe_manutencao')->num_rows();
        return $query;
    }

    public function ultima_manutencao($id) {
        $this->db->where('assets_id', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('pe_manutencao')->row_array();
        if (!$query) {
            return false;
        }
        return $query;
    }

    public function create($data) {
        $vfCiclo = $this->Pe_ciclo_vida_model->create([
            'staff_id' => $data['staff_id'],
            'assets_id' => $data['assets_id'],
            'fase' => 'manutencao',
            'data_inicio' => date('Y-m-d H:i:s'),
            'data_fim' => date('Y-m-d H:i:s'),
        ]);
        if ($vfCiclo) {
            $data['ciclo_vida_id'] = $vfCiclo['id'];
        }
        else {
            show_404();
            exit;
        }
        return $this->db->insert('pe_manutencao', $data);
    }
    public function get($tipo = null) {
    }
    public function get_assets($id) {
    }
    public function first($id) {
    }
    public function delete($id) {
    }
    public function update ($data, $id) {
    }
}