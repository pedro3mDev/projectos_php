<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_impacto_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_impacto')->num_rows();
        return $query;
    }
    public function create($data) {
        $vfimpacto = $this->db->get_where('pe_impacto', ['impacto' => $data['impacto']])->row_array();
        if ($vfimpacto) {
            set_alert('danger',"Impacto já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=impacto');
        }
        return $this->db->insert('pe_impacto', $data);
    }
    public function get() {
        $query = $this->db->get('pe_impacto');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_impacto', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfimpacto = $this->db->get_where('pe_impacto', ['impacto' => $data['impacto']])->row_array();
        if ($vfimpacto) {
            if ($id != $vfimpacto['id']) {
                set_alert('danger',"Impacto já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=impacto');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_impacto', $data);

        return $this->first($id);
    }

    public function delete($id) {
        $first = $this->first($id);
        // Risco Associadas
        $tot_risco = $this->db->get_where('pe_risco', ['impacto_id' => $id])->num_rows();
        $total = $tot_risco;
        if ($total != 0) {
            set_alert('danger',"Existem Riscos associada a este Impacto");
			redirect('politicas_empresa/configuracoes?group=impacto');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_impacto');
        return $first;
    }
}