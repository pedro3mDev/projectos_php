<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_politica_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pe_tipo_politica_model');
        $this->load->model('Pe_categoria_model');
        $this->load->model('Pe_area_model');
        $this->load->model('Pe_status_model');
        $this->load->model('Pe_nivel_hierarquico_model');
    }
    public function total()
    {
        $query = $this->db->get('pe_politica')->num_rows();
        return $query;
    }
    public function create($data)
    {
        $this->Pe_tipo_politica_model->first($data['tipo_politica_id']);
        $this->Pe_categoria_model->first($data['categoria_id']);
        // $this->Pe_area_model->first($data['area_id']);
        // $this->Pe_nivel_hierarquico_model->first($data['nivel_hierarquico_id']);
        // $this->Pe_status_model->first($data['status_id']);

        $vfPolitica = $this->db->get_where('pe_politica', [
            'tipo_politica_id' => $data['tipo_politica_id'],
            'categoria_id' => $data['categoria_id'],
            'conselho_id' => $data['conselho_id'],
            'pelorio_id' => $data['pelorio_id'],
            'direcao_id' => $data['direcao_id'],
            'departamento_id' => $data['departamento_id'],
            'seccao_id' => $data['seccao_id'],
            'titulo' => $data['titulo'],
        ])->row_array();
        if ($vfPolitica) {
            set_alert('danger', "Politica já foi cadastrada");
            redirect('politicas_empresa/listagem');
        }
        return $this->db->insert('pe_politica', $data);
    }

    public function get()
    {
        $this->db->select('
            pe_politica.*,
            staff.staffid, staff.firstname, staff.lastname,
            pe_tipo_politica.tipo_politica,
            pe_categoria.categoria,

            hr_conselhos.nome as conselho,
            hr_pelorios.nome as pelorio,
            hr_direcoes.nome as direcao,
            departments.name as departamento,
            hr_seccoes.nome as seccao,
        ');
        $this->db->from('pe_politica');
        $this->db->join('staff', 'staff.staffid = pe_politica.staff_id', 'left');
        $this->db->join('pe_tipo_politica', 'pe_tipo_politica.id = pe_politica.tipo_politica_id', 'left');
        $this->db->join('pe_categoria', 'pe_categoria.id = pe_politica.categoria_id', 'left');
        $this->db->join('hr_conselhos', 'hr_conselhos.id = pe_politica.conselho_id', 'left');
        $this->db->join('hr_pelorios', 'hr_pelorios.id = pe_politica.pelorio_id', 'left');
        $this->db->join('hr_direcoes', 'hr_direcoes.id = pe_politica.direcao_id', 'left');
        $this->db->join('departments', 'departments.departmentid = pe_politica.departamento_id', 'left');
        $this->db->join('hr_seccoes', 'hr_seccoes.id = pe_politica.seccao_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id)
    {
        $this->db->select('
            pe_politica.*,
            staff.staffid, staff.firstname, staff.lastname,
            pe_tipo_politica.tipo_politica,
            pe_categoria.categoria,

            hr_conselhos.nome as conselho,
            hr_pelorios.nome as pelorio,
            hr_direcoes.nome as direcao,
            departments.name as departamento,
            hr_seccoes.nome as seccao,
        ');
        $this->db->from('pe_politica');
        $this->db->join('staff', 'staff.staffid = pe_politica.staff_id', 'left');
        $this->db->join('pe_tipo_politica', 'pe_tipo_politica.id = pe_politica.tipo_politica_id', 'left');
        $this->db->join('pe_categoria', 'pe_categoria.id = pe_politica.categoria_id', 'left');
        $this->db->join('hr_conselhos', 'hr_conselhos.id = pe_politica.conselho_id', 'left');
        $this->db->join('hr_pelorios', 'hr_pelorios.id = pe_politica.pelorio_id', 'left');
        $this->db->join('hr_direcoes', 'hr_direcoes.id = pe_politica.direcao_id', 'left');
        $this->db->join('departments', 'departments.departmentid = pe_politica.departamento_id', 'left');
        $this->db->join('hr_seccoes', 'hr_seccoes.id = pe_politica.seccao_id', 'left');
        $this->db->where('pe_politica.id', $id);

        $query = $this->db->get()->row_array();

        // $query = $this->db->get_where('pe_politica', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update($data, $id)
    {
        $this->first($id);
        $this->Pe_tipo_politica_model->first($data['tipo_politica_id']);
        $this->Pe_categoria_model->first($data['categoria_id']);
        // $this->Pe_area_model->first($data['area_id']);
        // $this->Pe_nivel_hierarquico_model->first($data['nivel_hierarquico_id']);
        // $this->Pe_status_model->first($data['status_id']);

        $vfPolitica = $this->db->get_where('pe_politica', [
            'tipo_politica_id' => $data['tipo_politica_id'],
            'categoria_id' => $data['categoria_id'],
            'conselho_id' => $data['conselho_id'],
            'pelorio_id' => $data['pelorio_id'],
            'direcao_id' => $data['direcao_id'],
            'departamento_id' => $data['departamento_id'],
            'seccao_id' => $data['seccao_id'],
            'titulo' => $data['titulo'],
        ])->row_array();
        if ($vfPolitica) {
            if ($id != $vfPolitica['id']) {
                set_alert('danger', "Politica já foi cadastrada");
                return redirect('politicas_empresa/politica_editar/' . $id);
            }
        }

        $this->db->where('id', $id);
        $this->db->update('pe_politica', $data);

        return $this->first($id);
    }
    public function aprovar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_politica', $data);

        return $this->first($id);
    }
    public function rejeitar ($data, $id) {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('pe_politica', $data);

        return $this->first($id);
    }
    public function delete($id)
    {
        $first = $this->first($id);

        // Vefiricar se existe uma Politica Associada Antes de Eliminar
        // Conformidades Associadas
        $tot_conformidades = $this->db->get_where('pe_conformidade', ['politica_id' => $id])->num_rows();
        // Risco Associadas
        $tot_risco = $this->db->get_where('pe_risco', ['politica_id' => $id])->num_rows();
        $total = $tot_conformidades + $tot_risco;
        if ($total != 0) {
            set_alert('danger', "Esta Politica esta associada com outras entidades");
            redirect('politicas_empresa/listagem');
        }

        $this->db->where('id', $id);
        $this->db->delete('pe_politica');
        return $first;
    }

    public function getTotalPoliticas()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_politica')) {
            return $this->db->count_all(db_prefix() . 'pe_politica'); // Retorna o total de registros diretamente
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTotalConformidades()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_conformidade')) {
            return $this->db->count_all(db_prefix() . 'pe_conformidade'); // Retorna o total de registros diretamente
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTotalTipoProcedimentos()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_tipo_procedimento')) {
            return $this->db->count_all(db_prefix() . 'pe_tipo_procedimento'); // Retorna o total de registros diretamente
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTotalProcedimentos()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_procedimento')) {
            return $this->db->count_all(db_prefix() . 'pe_procedimento'); // Retorna o total de registros diretamente
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }

    public function getTotalRiscos()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_risco')) {
            return $this->db->count_all(db_prefix() . 'pe_risco'); // Retorna o total de registros diretamente
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTotalPoliticaPorTipo()
    {
        // Verifica se as tabelas existem antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'pe_politica') && $this->db->table_exists(db_prefix() . 'pe_tipo_politica')) {
            $this->db->select('tp.tipo_politica, COUNT(p.id) AS total_politicas');
            $this->db->from(db_prefix() . 'pe_politica AS p');
            $this->db->join(db_prefix() . 'pe_tipo_politica AS tp', 'p.tipo_politica_id = tp.id', 'inner');
            $this->db->group_by('tp.tipo_politica');
            $query = $this->db->get();
            return $query->result_array(); // Retorna os resultados como array associativo
        } else {
            return []; // Retorna uma lista vazia se as tabelas não existirem
        }
    }
}