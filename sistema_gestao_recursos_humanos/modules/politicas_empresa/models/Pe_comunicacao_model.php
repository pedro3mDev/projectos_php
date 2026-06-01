<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_comunicacao_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pe_politica_empresa_model');
        $this->load->model('Pe_politica_model');
    }
    public function total()
    {
        $query = $this->db->get('pe_comunicacao')->num_rows();
        return $query;
    }
    public function create($data)
    {
        $this->Pe_politica_empresa_model->first_staff($data['colaborador_id']);
        $this->Pe_politica_model->first($data['politica_id']);

        return $this->db->insert('pe_comunicacao', $data);
    }

    public function get()
    {
        $this->db->select('
            pe_comunicacao.*,
            staff.firstname, staff.lastname,
            staff_c.firstname as firstname_c, staff_c.lastname as lastname_c,
            pe_politica.titulo
        ');
        $this->db->from('pe_comunicacao');
        $this->db->join('staff', 'staff.staffid = pe_comunicacao.staff_id', 'left');
        $this->db->join('staff as staff_c', 'staff_c.staffid = pe_comunicacao.colaborador_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_comunicacao.politica_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id)
    {
        $this->db->select('
            pe_comunicacao.*,
            staff.firstname, staff.lastname,
            staff_c.firstname as firstname_c, staff_c.lastname as lastname_c,
            pe_politica.titulo
        ');
        $this->db->from('pe_comunicacao');
        $this->db->join('staff', 'staff.staffid = pe_comunicacao.staff_id', 'left');
        $this->db->join('staff as staff_c', 'staff_c.staffid = pe_comunicacao.colaborador_id', 'left');
        $this->db->join('pe_politica', 'pe_politica.id = pe_comunicacao.politica_id', 'left');
        $this->db->where('pe_comunicacao.id', $id);

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
        $this->Pe_politica_empresa_model->first_staff($data['colaborador_id']);
        $this->Pe_politica_model->first($data['politica_id']);

        $this->db->where('id', $id);
        $this->db->update('pe_comunicacao', $data);

        return $this->first($id);
    }
    public function aprovar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_comunicacao', $data);

        return $this->first($id);
    }
    public function rejeitar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_comunicacao', $data);

        return $this->first($id);
    }
    public function delete($id)
    {
        $first = $this->first($id);
        $this->db->where('id', $id);
        $this->db->delete('pe_comunicacao');
        return $first;
    }
    public function getTotalConformidadeByStatus($status = 'pendente')
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_comunicacao')) {
            $this->db->from(db_prefix() . 'pe_comunicacao');
            $this->db->where('status', $status); // Adiciona a condição de status
            return $this->db->count_all_results(); // Retorna apenas o total de registros para o status especificado
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }

    public function get_status_totals_with_percentages()
    {
        // Consulta para contar registros por status
        $this->db->select("
        status,
        COUNT(*) AS total,
        ROUND((COUNT(*) * 100 / (SELECT COUNT(*) FROM " . db_prefix() . "pe_comunicacao)), 2) AS percentual
    ");
        $this->db->from(db_prefix() . 'pe_comunicacao');
        $this->db->group_by('status'); // Agrupa por status

        // Executa a consulta
        $query = $this->db->get();
        return $query->result_array(); // Retorna um array com o total e percentual por status
    }
}