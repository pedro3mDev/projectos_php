<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_nivel_hierarquico_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_nivel_hierarquico')->num_rows();
        return $query;
    }
    public function create($data) {
        $vfnivel_hierarquico = $this->db->get_where('pe_nivel_hierarquico', ['nivel_hierarquico' => $data['nivel_hierarquico']])->row_array();
        if ($vfnivel_hierarquico) {
            set_alert('danger',"Nível Hierárquico já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
        }
        return $this->db->insert('pe_nivel_hierarquico', $data);
    }
    public function get() {
        $query = $this->db->get('pe_nivel_hierarquico');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_nivel_hierarquico', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfnivel_hierarquico = $this->db->get_where('pe_nivel_hierarquico', ['nivel_hierarquico' => $data['nivel_hierarquico']])->row_array();
        if ($vfnivel_hierarquico) {
            if ($id != $vfnivel_hierarquico['id']) {
                set_alert('danger',"Nível Hierárquico já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_nivel_hierarquico', $data);

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
            set_alert('danger',"Existe Politica associada com este Nivel Hierarquico");
			redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_nivel_hierarquico');
        return $first;
    }
}