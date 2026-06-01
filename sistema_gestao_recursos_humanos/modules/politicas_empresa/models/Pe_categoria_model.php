<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_categoria_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_categoria')->num_rows();
        return $query;
    }
    public function create($data) {
        $vftipo_politica = $this->db->get_where('pe_categoria', ['categoria' => $data['categoria']])->row_array();
        if ($vftipo_politica) {
            set_alert('danger',"Categoria já foi cadastrada");
            redirect('politicas_empresa/configuracoes?group=categoria');
        }
        return $this->db->insert('pe_categoria', $data);
    }
    public function get() {
        $query = $this->db->get('pe_categoria');
        return $query->result_array();
    }
    public function first($id) {
        $query = $this->db->get_where('pe_categoria', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vftipo_politica = $this->db->get_where('pe_categoria', ['categoria' => $data['categoria']])->row_array();
        if ($vftipo_politica) {
            if ($id != $vftipo_politica['id']) {
                set_alert('danger',"Categoria já foi cadastrada");
			    redirect('politicas_empresa/configuracoes?group=categoria');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_categoria', $data);

        return $this->first($id);
    }

    public function delete($id) {
        $first = $this->first($id);
        // Politicas Associadas
        $tot_politica = $this->db->get_where('pe_politica', ['categoria_id' => $id])->num_rows();
        $total = $tot_politica;
        if ($total != 0) {
            set_alert('danger',"Existe Politica associada com esta Categoria");
			redirect('politicas_empresa/configuracoes?group=categoria');
        }
        $this->db->where('id', $id);
        $this->db->delete('pe_categoria');
        return $first;
    }
}