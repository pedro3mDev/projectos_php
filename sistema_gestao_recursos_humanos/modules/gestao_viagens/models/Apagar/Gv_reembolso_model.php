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
        $this->db->select('gv_orcamento_viagem.*, gv_reembolso_viagem.id as remmbolso_id, gv_reembolso_viagem.reembolso');
        $this->db->from('gv_reembolso_viagem');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_reembolso_viagem.orcamento_viagem_id');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function first($id) {
        $query = $this->db->get_where('gv_reembolso_viagem', ['id' => $id])->row_array();

        $this->db->select('gv_orcamento_viagem.*, gv_reembolso_viagem.id as remmbolso_id, gv_reembolso_viagem.reembolso');
        $this->db->from('gv_reembolso_viagem');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_reembolso_viagem.orcamento_viagem_id');
        $this->db->where('gv_reembolso_viagem.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Reembolso não encontrado']);
            exit;
        }
        return $query;
    }
    public function first_orcamento($id) {
        $query = $this->db->get_where('gv_reembolso_viagem', ['orcamento_viagem_id' => $id])->row_array();
        return $query;
    }

    public function create($data) {
        $this->Gv_orcamento_viagem_model->first($data['orcamento_viagem_id']);

        $vfOrcamento = $this->db->get_where('gv_reembolso_viagem', ['orcamento_viagem_id' => $data['orcamento_viagem_id']])->row_array();
        if ($vfOrcamento) {
            return false;
        }
        return $this->db->insert('gv_reembolso_viagem', $data);
    }

    public function update($data, $id)  {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('gv_reembolso_viagem', $data);

        return $this->first($id);
    }

    public function delete ($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_reembolso_viagem');

        return $first;
    }
}