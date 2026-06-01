<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_reembolso_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_orcamento_viagem_model');
    }

    public function total($id)
    {
        $query = $this->db->where('pedido_viagem_id', $id)->get('gv_equipa_viagem');
        return $query->num_rows();
    }

    public function get()
    {
        $this->db->select('gv_orcamento_viagem.*, gv_reembolso.id as remmbolso_id, gv_reembolso.reembolso');
        $this->db->from('gv_reembolso');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_reembolso.orcamento_viagem_id');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function first($id) {
        $query = $this->db->get_where('gv_reembolso', ['id' => $id])->row_array();

        $this->db->select('gv_orcamento_viagem.*, gv_reembolso.id as remmbolso_id, gv_reembolso.reembolso');
        $this->db->from('gv_reembolso');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_reembolso.orcamento_viagem_id');
        $this->db->where('gv_reembolso.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Reembolso não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data) {
        $this->Gv_orcamento_viagem_model->first($data['orcamento_viagem_id']);

        $vfOrcamento = $this->db->get_where('gv_reembolso', ['orcamento_viagem_id' => $data['orcamento_viagem_id']])->row_array();
        if ($vfOrcamento) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Reembolso já foi cadastrado.']);
            exit;
        }
        return $this->db->insert('gv_reembolso', $data);
    }

    public function update($data, $id)  {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('gv_reembolso', $data);

        return $this->first($id);
    }

    public function delete ($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_reembolso');

        return $first;
    }
}