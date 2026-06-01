<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_tipo_politica_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_tipo_politica')->num_rows();
        return $query;
    }
    public function create($data) {
        $vftipo_politica = $this->db->get_where('pe_tipo_politica', ['tipo_politica' => $data['tipo_politica']])->row_array();
        if ($vftipo_politica) {
            set_alert('danger',"Tipo de Politica já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=tipo_politica');
        }
        return $this->db->insert('pe_tipo_politica', $data);
    }
    public function get() {
        $query = $this->db->get('pe_tipo_politica');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_tipo_politica', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vftipo_politica = $this->db->get_where('pe_tipo_politica', ['tipo_politica' => $data['tipo_politica']])->row_array();
        if ($vftipo_politica) {
            if ($id != $vftipo_politica['id']) {
                set_alert('danger',"Tipo de Politica já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=tipo_politica');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_tipo_politica', $data);

        return $this->first($id);
    }

    public function delete($id) {
        $first = $this->first($id);
        // Politicas Associadas
        $tot_politica = $this->db->get_where('pe_politica', ['tipo_politica_id' => $id])->num_rows();
        $total = $tot_politica;
        if ($total != 0) {
            set_alert('danger',"Existe Politica associada com este Tipo de Polilica");
			redirect('politicas_empresa/configuracoes?group=tipo_politica');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_tipo_politica');
        return $first;
    }
}