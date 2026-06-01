<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_procedimento_model extends CI_Model
{
    public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_tipo_procedimento_model');
	}
    public function total() {
        $query = $this->db->get('pe_procedimento')->num_rows();
        return $query;
    }
    public function create($data) {
        $this->Pe_politica_empresa_model->first_staff($data['staff_procedimento_id']);
        $this->Pe_politica_model->first($data['politica_id']);
        $this->Pe_tipo_procedimento_model->first($data['tipo_procedimento_id']);

        return $this->db->insert('pe_procedimento', $data);
    }

    public function get($status = null) {
        $this->db->select('
            pe_procedimento.*,
            staff.firstname, staff.lastname,
            staff_c.firstname as firstname_c, staff_c.lastname as lastname_c,
            pe_tipo_procedimento.tipo_procedimento,
            pe_processo.titulo as titulo_p, pe_processo.descricao as descricao_p, pe_processo.data_verificacao,
            pe_politica.titulo,
        ');
        $this->db->from('pe_procedimento');
        $this->db->join('staff', 'staff.staffid = pe_procedimento.staff_id', 'left');
        $this->db->join('staff as staff_c', 'staff_c.staffid = pe_procedimento.staff_procedimento_id', 'left');
        $this->db->join('pe_tipo_procedimento', 'pe_tipo_procedimento.id = pe_procedimento.tipo_procedimento_id', 'left');
        $this->db->join('pe_processo', 'pe_processo.id = pe_procedimento.processo_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_procedimento.politica_id', 'left');
        if (!empty($status)) {
            $this->db->where('pe_procedimento.status', $status);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id) {
        $this->db->select('
            pe_procedimento.*,
            staff.firstname, staff.lastname,
            staff_c.firstname as firstname_c, staff_c.lastname as lastname_c,
            pe_tipo_procedimento.tipo_procedimento,
            pe_processo.titulo as titulo_p, pe_processo.descricao as descricao_p, pe_processo.data_verificacao,
            pe_politica.titulo
        ');
        $this->db->from('pe_procedimento');
        $this->db->join('staff', 'staff.staffid = pe_procedimento.staff_id', 'left');
        $this->db->join('staff as staff_c', 'staff_c.staffid = pe_procedimento.staff_procedimento_id', 'left');
        $this->db->join('pe_tipo_procedimento', 'pe_tipo_procedimento.id = pe_procedimento.tipo_procedimento_id', 'left');
        $this->db->join('pe_processo', 'pe_processo.id = pe_procedimento.processo_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_procedimento.politica_id', 'left');
        $this->db->where('pe_procedimento.id', $id);

        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $this->Pe_politica_empresa_model->first_staff($data['staff_procedimento_id']);
        $this->Pe_politica_model->first($data['politica_id']);

        $this->db->where('id', $id);
        $this->db->update('pe_procedimento', $data);

        return $this->first($id);
    }
    public function delete($id) {
        $first = $this->first($id);

        // Vefiricar se existe uma Politica Associada Antes de Eliminar
        // $vfpolitica = true;
        // if ($vfpolitica) {
        //     set_alert('danger',"Esta Conformidade esta associada com outras entidades");
		// 	redirect('politicas_empresa/procedimentos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('pe_procedimento');
        return $first;
    }
    public function aprovar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_procedimento', $data);

        return $this->first($id);
    }
    public function rejeitar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_procedimento', $data);

        return $this->first($id);
    }

    public function getTotalProcedimentoByStatus($status = 'pendente')
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_procedimento')) {
            $this->db->from(db_prefix() . 'pe_procedimento');
            $this->db->where('status', $status); // Adiciona a condição de status
            return $this->db->count_all_results(); // Retorna apenas o total de registros para o status especificado
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
}