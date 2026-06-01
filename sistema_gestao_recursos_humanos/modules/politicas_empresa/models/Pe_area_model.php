<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_area_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_area')->num_rows();
        return $query;
    }
    public function create($data) {
        $vfarea = $this->db->get_where('pe_area', ['area' => $data['area']])->row_array();
        if ($vfarea) {
            set_alert('danger',"Area já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=area');
        }
        return $this->db->insert('pe_area', $data);
    }
    public function get() {
        $query = $this->db->get('pe_area');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_area', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfarea = $this->db->get_where('pe_area', ['area' => $data['area']])->row_array();
        if ($vfarea) {
            if ($id != $vfarea['id']) {
                set_alert('danger',"Area já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=area');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_area', $data);

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
            set_alert('danger',"Existe Politica associada com esta Area");
			redirect('politicas_empresa/configuracoes?group=area');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_area');
        return $first;
    }
}