<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_reserva_voo_model extends App_Model
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
        $this->db->from('gv_status_pedido');
        $query = $this->db->get();
        return array_column($query->result_array(), 'pedido_viagem_id');
    }

    public function get($id)
    {
        $this->Gv_pedido_model->first($id);
        $query = $this->db->where('pedido_viagem_id', $id)->get('gv_reserva_voo');
        return $query->result_array();
    }

    public function first($dados) {
        if (!isset($dados['id_pedido']) OR !isset($dados['id'])) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Dados não encontrado']);
            exit;
        }
        $this->Gv_pedido_model->first($dados['id_pedido']);

        $query = $this->db->get_where('gv_reserva_voo', ['id' => $dados['id'], 'pedido_viagem_id' => $dados['id_pedido']])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Reserva de Voo não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data) {
        $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        return $this->db->insert('gv_reserva_voo', $data);
    }

    public function update($data, $id)  {
        $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id' => $id,
        ]);

        $this->db->where('id', $id);
        $this->db->update('gv_reserva_voo', $data);

        return $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id' => $id
        ]);
    }

    public function delete ($dado) {
        $first = $this->first($dado);

        $this->db->where('id', $dado['id']);
        $this->db->delete('gv_reserva_voo');

        return $first;
    }
}