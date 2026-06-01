<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_politica_categoria_model extends CI_Model
{
    public function in($id) {
        $this->db->select('categoria_id');
        $this->db->from('pe_categoria_politica');
        $this->db->where('politica_id', $id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'categoria_id');
    }
    public function get_categorias($id) {
        $ids = $this->in($id);
        $this->db->select('*');
        $this->db->from('pe_categoria');
        if ($ids) {
            $this->db->where_not_in('id', $ids);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get($id) {
        $this->db->select('pe_categoria_politica.*, pe_categoria.categoria');
        $this->db->from('pe_categoria_politica');
        $this->db->join('pe_categoria', 'pe_categoria.id = pe_categoria_politica.categoria_id', 'right');
        $this->db->where('pe_categoria_politica.politica_id', $id);

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function create($data) {
        $vfCategoria = $this->db->get_where('pe_categoria_politica', [
            'categoria_id' => $data['categoria_id'],
            'politica_id' => $data['politica_id'],
        ])->row_array();
        if ($vfCategoria) {
            set_alert('danger',"Categoria já foi Adicionada");
			redirect('politicas_empresa/seguranca_escritorio/politica/'.$data['politica_id']);
        }
        return $this->db->insert('pe_categoria_politica', $data);
    }
    public function first($id, $id_catpoli) {
        $query = $this->db->get_where('pe_categoria_politica', [
            'id' => $id_catpoli,
            'politica_id' => $id,
        ])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }

    public function delete($id, $id_catpoli) {
        $first = $this->first($id, $id_catpoli);

        $this->db->where('id', $id_catpoli);
        $this->db->delete('pe_categoria_politica');
        return $first;
    }
}