<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_movimentacao_model extends CI_Model
{
    public function __construct() {
		parent::__construct();
		$this->load->model('Pe_assets_model');
		$this->load->model('Pe_ciclo_vida_model');
	}
    public function total() {
        $query = $this->db->get('pe_movimentacao')->num_rows();
        return $query;
    }

    public function ultimo_movimento($id) {
        $this->db->where('assets_id', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('pe_movimentacao')->row_array();
        if (!$query) {
            return false;
        }
        return $query;
    }

    public function create($data) {
        $vfUltimoM = $this->ultimo_movimento($data['assets_id']);
        if ($vfUltimoM) {
            $data['localizacao_assets_origem_id'] = $vfUltimoM['localizacao_assets_destino_id'];
        }
        $vfCiclo = $this->Pe_ciclo_vida_model->create([
            'staff_id' => $data['staff_id'],
            'assets_id' => $data['assets_id'],
            'fase' => 'operacao',
            'data_inicio' => date('Y-m-d'),
            'data_fim' => date('Y-m-d'),
        ]);
        if ($vfCiclo) {
            $data['ciclo_vida_id'] = $vfCiclo['id'];
        }
        else {
            show_404();
            exit;
        }
        return $this->db->insert('pe_movimentacao', $data);
    }
    public function get($tipo = null) {
        return [];
    }
    public function get_assets($id) {
        $this->db->select('pe_ciclo_vida.*, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('pe_ciclo_vida');
        $this->db->join('staff', 'staff.staffid = pe_ciclo_vida.staff_id');
        $this->db->join('pe_manutencao', 'pe_manutencao.ciclo_vida_id = pe_ciclo_vida.id', 'right');
        $this->db->join('pe_movimentacao', 'pe_movimentacao.ciclo_vida_id = pe_ciclo_vida.id', 'right');
        $this->db->where('pe_ciclo_vida.assets_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id) {
        $this->db->select('pe_ciclo_vida.*, staff.staffid, staff.firstname, staff.lastname, pe_politica.titulo');
        $this->db->from('pe_ciclo_vida');
        $this->db->join('staff', 'staff.staffid = pe_ciclo_vida.staff_id');
        $this->db->join('pe_politica', 'pe_politica.id = pe_ciclo_vida.politica_id');
        $this->db->where('pe_ciclo_vida.id', $id);

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
        $this->db->delete('pe_ciclo_vida');
        return $first;
    }
    public function update ($data, $id) {
        $this->first($id);
        $this->db->where('id', $id);
        $this->db->update('pe_ciclo_vida', $data);

        return $this->first($id);
    }
}