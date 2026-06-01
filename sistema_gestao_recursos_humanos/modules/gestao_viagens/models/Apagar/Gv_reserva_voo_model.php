<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_reserva_voo_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
    }

    public function pedidos()
    {
        $this->db->select('id');
        $this->db->from('gv_pedido_viagem');
        $query = $this->db->get();
        $res = array_column($query->result_array(), 'id');
        if ($res) {
            return $res;
        }
        return [];
    }
    public function verificados()
    {
        $this->db->select('pedido_viagem_id');
        $this->db->from('gv_status_pedido');
        $query = $this->db->get();
        return array_column($query->result_array(), 'pedido_viagem_id');
    }

    public function get($id)
    {
        $this->Gv_pedido_model->first($id);

        $this->db->select('gv_reserva_voo.*, gv_status.status');
        $this->db->from('gv_reserva_voo');
        $this->db->join('gv_status', 'gv_status.id = gv_reserva_voo.status_id', 'right');
        $this->db->where('gv_reserva_voo.pedido_viagem_id', $id);

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_alg_bellman($id)
    {
        $this->Gv_pedido_model->first($id);

        $grafo = [];
        $vertices = [];
        $this->db->select('partida, destino, preco');
        $this->db->from('gv_reserva_voo');
        $this->db->where('pedido_viagem_id', $id);
        $dados = $this->db->get()->result_array();
        foreach ($dados as $dado) {
            $grafo[] = [$dado['partida'], $dado['destino'], (float)$dado['preco']];

            if (!in_array($dado['partida'], $vertices)) $vertices[] = $dado['partida'];
            if (!in_array($dado['destino'], $vertices)) $vertices[] = $dado['destino'];
        }

        return [
            'grafico' => $grafo,
            'vertices' => $vertices,
        ];
    }

    public function first($dados)
    {
        if (!isset($dados['pedido_viagem_id']) or !isset($dados['id'])) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Dados não encontrado']);
            exit;
        }
        $this->Gv_pedido_model->first($dados['pedido_viagem_id']);

        $query = $this->db->get_where('gv_reserva_voo', ['id' => $dados['id'], 'pedido_viagem_id' => $dados['pedido_viagem_id']])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Reserva de Voo não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data)
    {
        $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        return $this->db->insert('gv_reserva_voo', $data);
    }

    public function update($data, $id)
    {
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

    public function delete($dado)
    {
        $first = $this->first($dado);

        $this->db->where('id', $dado['id']);
        $this->db->delete('gv_reserva_voo');

        return $first;
    }

    public function get_total()
    {
        $this->db->select('COUNT(*) AS total');
        $query = $this->db->get(db_prefix() . 'gv_reserva_voo');
        return $query->row()->total; // Retorna um objeto com o total de registros
    }
    function obter_destinos_mais_visitados($limite = 10)
    {
        $CI = &get_instance();
        $CI->db->select('destino, COUNT(destino) AS total_visitas');
        $CI->db->from(db_prefix() . 'gv_reserva_voo');
        $CI->db->group_by('destino');
        $CI->db->order_by('total_visitas', 'DESC');
        $CI->db->limit($limite);
        $query = $CI->db->get();

        return $query->result_array(); // Retorna os dados como array associativo
    }
}
