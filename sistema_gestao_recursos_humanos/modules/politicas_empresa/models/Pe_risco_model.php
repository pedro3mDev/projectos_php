<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_risco_model extends CI_Model
{
    public function __construct() {
		parent::__construct();
		$this->load->model('Pe_impacto_model');
		$this->load->model('Pe_politica_model');
	}
    public function total() {
        $query = $this->db->get('pe_risco')->num_rows();
        return $query;
    }
    public function create($data) {
        $this->Pe_politica_model->first($data['politica_id']);
        $this->Pe_impacto_model->first($data['impacto_id']);

        return $this->db->insert('pe_risco', $data);
    }

    public function get() {
        $this->db->select('
            pe_risco.*,
            staff.firstname, staff.lastname,
            pe_politica.titulo,
            pe_impacto.impacto, pe_impacto.valor_impacto,
            pe_probabilidade.descricao as descricao_p, pe_probabilidade.valor_probabilidade,

            (valor_probabilidade * valor_impacto) as nivel_risco
        ');
        $this->db->from('pe_risco');
        $this->db->join('staff', 'staff.staffid = pe_risco.staff_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_risco.politica_id', 'left');
        $this->db->join('pe_impacto', 'pe_impacto.id = pe_risco.impacto_id', 'left');
        $this->db->join('pe_probabilidade', 'pe_probabilidade.id = pe_risco.probabilidade_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function get_matriz_vertical() {
        $this->db->select('
            pe_risco.*,
            staff.firstname, staff.lastname,
            pe_politica.titulo,
            pe_impacto.impacto, pe_impacto.valor_impacto,
            pe_probabilidade.descricao as descricao_p, pe_probabilidade.valor_probabilidade,

            (valor_probabilidade * valor_impacto) as nivel_risco
        ');
        $this->db->from('pe_risco');
        $this->db->join('staff', 'staff.staffid = pe_risco.staff_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_risco.politica_id', 'left');
        $this->db->join('pe_impacto', 'pe_impacto.id = pe_risco.impacto_id', 'left');
        $this->db->join('pe_probabilidade', 'pe_probabilidade.id = pe_risco.probabilidade_id', 'left');
        $this->db->order_by('nivel_risco', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id) {
        $this->db->select('
            pe_risco.*,
            staff.firstname, staff.lastname,
            pe_politica.titulo,
            pe_impacto.impacto, pe_impacto.valor_impacto,
            pe_probabilidade.descricao as descricao_p, pe_probabilidade.valor_probabilidade,

            (valor_probabilidade * valor_impacto) as nivel_risco
        ');
        $this->db->from('pe_risco');
        $this->db->join('staff', 'staff.staffid = pe_risco.staff_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_risco.politica_id', 'left');
        $this->db->join('pe_impacto', 'pe_impacto.id = pe_risco.impacto_id', 'left');
        $this->db->join('pe_probabilidade', 'pe_probabilidade.id = pe_risco.probabilidade_id', 'left');
        $this->db->where('pe_risco.id', $id);

        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $this->Pe_politica_model->first($data['politica_id']);
        $this->Pe_impacto_model->first($data['impacto_id']);

        $this->db->where('id', $id);
        $this->db->update('pe_risco', $data);

        return $this->first($id);
    }
    public function aprovar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_risco', $data);

        return $this->first($id);
    }
    public function rejeitar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_risco', $data);

        return $this->first($id);
    }
    public function delete($id) {
        $first = $this->first($id);

        // Vefiricar se existe uma Politica Associada Antes de Eliminar
        //
        //
        //
        $vfpolitica = true;
        if ($vfpolitica) {
            set_alert('danger',"Esta Conformidade esta associada com outras entidades");
			redirect('politicas_empresa/riscos');
        }

        $this->db->where('id', $id);
        $this->db->delete('pe_risco');
        return $first;
    }
}