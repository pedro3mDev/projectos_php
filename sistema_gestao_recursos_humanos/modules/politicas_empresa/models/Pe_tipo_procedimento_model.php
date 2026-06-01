<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_tipo_procedimento_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_tipo_procedimento')->num_rows();
        return $query;
    }
    public function create($data) {
        $vftipo_procedimento = $this->db->get_where('pe_tipo_procedimento', ['tipo_procedimento' => $data['tipo_procedimento']])->row_array();
        if ($vftipo_procedimento) {
            set_alert('danger',"Tipo de Procedimento já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
        }
        return $this->db->insert('pe_tipo_procedimento', $data);
    }
    public function get() {
        $query = $this->db->get('pe_tipo_procedimento');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_tipo_procedimento', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vftipo_procedimento = $this->db->get_where('pe_tipo_procedimento', ['tipo_procedimento' => $data['tipo_procedimento']])->row_array();
        if ($vftipo_procedimento) {
            if ($id != $vftipo_procedimento['id']) {
                set_alert('danger',"Tipo de Procedimento já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_tipo_procedimento', $data);

        return $this->first($id);
    }

    public function delete($id) {
        $first = $this->first($id);
        $total = $this->db->get_where('pe_procedimento', ['tipo_procedimento_id' => $id])->num_rows();
        if ($total != 0) {
            set_alert('danger',"Existe Procedimento associada com este Tipo de Procedimento");
			redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_tipo_procedimento');
        return $first;
    }
}