<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_ciclo_vida_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_ciclo_vida')->num_rows();
        return $query;
    }

    public function create($data) {
        $this->db->insert('pe_ciclo_vida', $data);

        $this->db->where('staff_id', $data['staff_id']);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('pe_ciclo_vida')->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function get($tipo = null) {
        // $this->db->select('pe_ciclo_vida.*, staff.staffid, staff.firstname, staff.lastname, pe_politica.titulo');
        // $this->db->from('pe_ciclo_vida');
        // $this->db->join('staff', 'staff.staffid = pe_ciclo_vida.staff_id');
        // $this->db->join('pe_politica', 'pe_politica.id = pe_ciclo_vida.politica_id');

        // if ($tipo != null AND $tipo == 'conformidade' OR $tipo == 'confidencialidade') {
        //     $this->db->where('pe_ciclo_vida.tipo_termo', $tipo);
        // }
        // $query = $this->db->get()->result_array();
        // return $query;
        return [];
    }
    public function get_assets_b($id) {
        $this->db->select('
            pe_ciclo_vida.*,
            staff.staffid, staff.firstname, staff.lastname,

            pe_movimentacao.localizacao_assets_origem_id, pe_movimentacao.localizacao_assets_destino_id, pe_movimentacao.data_movimento,
            lc_origem.localizacao as localizacao_origem, lc_destino.localizacao as localizacao_destino,

        ');
        $this->db->from('pe_ciclo_vida');
        $this->db->join('staff', 'staff.staffid = pe_ciclo_vida.staff_id', 'left');
        $this->db->join('pe_movimentacao', 'pe_movimentacao.ciclo_vida_id = pe_ciclo_vida.id', 'left');
        $this->db->join('pe_localizacao_assets as lc_origem', 'lc_origem.id = pe_movimentacao.localizacao_assets_origem_id', 'left');
        $this->db->join('pe_localizacao_assets as lc_destino', 'lc_destino.id = pe_movimentacao.localizacao_assets_destino_id', 'left');
        // $this->db->join('staff as staff_m', 'staff_m.staffid = pe_movimentacao.staff_id');


        $this->db->where('pe_ciclo_vida.assets_id', $id);
        // $query = $this->db->get('pe_ciclo_vida');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_assets($id) {
        $this->db->select('
            pe_ciclo_vida.*,
            staff.staffid, staff.firstname, staff.lastname,

            pe_movimentacao.localizacao_assets_origem_id, pe_movimentacao.localizacao_assets_destino_id, pe_movimentacao.data_movimento,
            lc_origem.localizacao as localizacao_origem, lc_destino.localizacao as localizacao_destino,

            pe_manutencao.id as manutencao_id, pe_manutencao.tipo, pe_manutencao.descricao as m_descricao, pe_manutencao.data_manutencao,
        ');
        $this->db->from('pe_ciclo_vida');
        $this->db->join('staff', 'staff.staffid = pe_ciclo_vida.staff_id', 'left');
        // Movimentacao
        $this->db->join('pe_movimentacao', 'pe_movimentacao.ciclo_vida_id = pe_ciclo_vida.id', 'left');
        $this->db->join('pe_localizacao_assets as lc_origem', 'lc_origem.id = pe_movimentacao.localizacao_assets_origem_id', 'left');
        $this->db->join('pe_localizacao_assets as lc_destino', 'lc_destino.id = pe_movimentacao.localizacao_assets_destino_id', 'left');
        // $this->db->join('staff as staff_m', 'staff_m.staffid = pe_movimentacao.staff_id');
        // Manuntençao
        $this->db->join('pe_manutencao', 'pe_manutencao.ciclo_vida_id = pe_ciclo_vida.id', 'left');

        $this->db->where('pe_ciclo_vida.assets_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    // public function first($id) {
    //     $this->db->select('pe_ciclo_vida.*, staff.staffid, staff.firstname, staff.lastname, pe_politica.titulo');
    //     $this->db->from('pe_ciclo_vida');
    //     $this->db->join('staff', 'staff.staffid = pe_ciclo_vida.staff_id');
    //     $this->db->join('pe_politica', 'pe_politica.id = pe_ciclo_vida.politica_id');
    //     $this->db->where('pe_ciclo_vida.id', $id);

    //     $query = $this->db->get()->row_array();
    //     if (!$query) {
    //         show_404();
    //         exit;
    //     }
    //     return $query;
    // }
    // public function delete($id) {
    //     $first = $this->first($id);

    //     $this->db->where('id', $id);
    //     $this->db->delete('pe_ciclo_vida');
    //     return $first;
    // }
    // public function update ($data, $id) {
    //     $this->first($id);
    //     $this->db->where('id', $id);
    //     $this->db->update('pe_ciclo_vida', $data);

    //     return $this->first($id);
    // }
}