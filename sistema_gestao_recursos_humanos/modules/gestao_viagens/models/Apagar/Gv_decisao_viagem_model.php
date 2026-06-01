<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_decisao_viagem_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
    }

    public function pedidos () {
        $this->db->select('id');
        $this->db->from('gv_pedido_viagem');
        $query = $this->db->get();
        $res = array_column($query->result_array(), 'id');
        if ($res) {
            return $res;
        }
        return [];
    }
    public function verificados () {
        $this->db->select('pedido_viagem_id');
        $this->db->from('gv_decisao_viagem');
        $query = $this->db->get();
        return array_column($query->result_array(), 'pedido_viagem_id');
    }

    public function get($status)
    {
        // $this->db->select('gv_pedido_viagem.id, gv_pedido_viagem.status_id, gv_pedido_viagem.tipo_viagem, gv_pedido_viagem.objetivo, gv_pedido_viagem.destino,  gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim, gv_pedido_viagem.data_criacao, gv_pedido_viagem.data_actualizacao');
        $this->db->select('gv_pedido_viagem.*');
        $this->db->from('gv_decisao_viagem');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_decisao_viagem.pedido_viagem_id');
        $this->db->where('gv_decisao_viagem.status', $status);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_pendente() {
        $ids_pedido = $this->verificados();
        $this->db->select('id, status_id, tipo_viagem, objetivo, destino, data_inicio, data_fim, data_criacao, data_actualizacao');
        $this->db->from('gv_pedido_viagem');
        if ($ids_pedido) {
            $this->db->where_not_in('id', $ids_pedido);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function total($status) {
        // $this->db->select('gv_pedido_viagem.id, gv_pedido_viagem.status_id, gv_pedido_viagem.tipo_viagem, gv_pedido_viagem.objetivo, gv_pedido_viagem.destino,  gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim, gv_pedido_viagem.data_criacao, gv_pedido_viagem.data_actualizacao');
        $this->db->select('gv_pedido_viagem.*');
        $this->db->from('gv_decisao_viagem');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_decisao_viagem.pedido_viagem_id');
        $this->db->where('gv_decisao_viagem.decisao', $status);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    public function total_pendente() {
        $ids_pedido = $this->verificados();
        $this->db->select('*');
        $this->db->from('gv_pedido_viagem');
        if ($ids_pedido) {
            $this->db->where_not_in('id', $ids_pedido);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    public function first_pedido($id) {
        $query = $this->db->get_where('gv_decisao_viagem', ['pedido_viagem_id' => $id])->row_array();
        return $query;
    }

    public function first($id) {
        $query = $this->db->get_where('gv_decisao_viagem', ['id' => $id])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Status de Pedido de Viagem não encontrado']);
            exit;
        }
        return $query;
    }

    public function decisao($data) {
        $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        $query = $this->db->get_where('gv_decisao_viagem', ['pedido_viagem_id' => $data['pedido_viagem_id']])->row_array();
        if ($query) {
            return false;
        }
        return $this->db->insert('gv_decisao_viagem', $data);
    }

    public function update($data, $id)  {
        $this->first($id);
        if (isset($data['pedido_viagem_id'])) {
            $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        }

        $this->db->where('id', $id);
        $this->db->update('gv_decisao_viagem', $data);

        return $this->first($id);
    }

    public function delete ($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_decisao_viagem');

        return $first;
    }
}