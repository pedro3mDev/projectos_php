<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_status_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_status')->num_rows();
        return $query;
    }
    public function create($data) {
        $vfstatus = $this->db->get_where('pe_status', ['status' => $data['status']])->row_array();
        if ($vfstatus) {
            set_alert('danger',"Estado já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=estado');
        }
        return $this->db->insert('pe_status', $data);
    }
    public function get() {
        $query = $this->db->get('pe_status');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_status', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfstatus = $this->db->get_where('pe_status', ['status' => $data['status']])->row_array();
        if ($vfstatus) {
            if ($id != $vfstatus['id']) {
                set_alert('danger',"Estado já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=estado');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_status', $data);

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
            set_alert('danger',"Existe Politica associada com este Estado");
			redirect('politicas_empresa/configuracoes?group=estado');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_status');
        return $first;
    }
}