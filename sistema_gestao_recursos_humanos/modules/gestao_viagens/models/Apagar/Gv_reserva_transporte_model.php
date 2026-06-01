<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_reserva_transporte_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
    }

    public function get($id)
    {
        $this->Gv_pedido_model->first($id);

        $this->db->select('gv_reserva_transporte.*, gv_status.status');
        $this->db->from('gv_reserva_transporte');
        $this->db->join('gv_status', 'gv_status.id = gv_reserva_transporte.status_id');
        $this->db->where('gv_reserva_transporte.pedido_viagem_id', $id);

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_alg_bellman($id) {
        $this->Gv_pedido_model->first($id);

        $grafo = [];
        $vertices = [];
        $this->db->select('local_partida, local_destino, preco');
        $this->db->from('gv_reserva_transporte');
        $this->db->where('pedido_viagem_id', $id);
        $dados = $this->db->get()->result_array();
        foreach ($dados as $dado) {
            $grafo[] = [$dado['local_partida'], $dado['local_destino'], (float)$dado['preco']];

            if (!in_array($dado['local_partida'], $vertices)) $vertices[] = $dado['local_partida'];
            if (!in_array($dado['local_destino'], $vertices)) $vertices[] = $dado['local_destino'];
        }

        return [
            'grafico' => $grafo,
            'vertices' => $vertices,
        ];
    }

    public function first($dados) {
        if (!isset($dados['pedido_viagem_id']) OR !isset($dados['id'])) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Dados não encontrado']);
            exit;
        }
        $this->Gv_pedido_model->first($dados['pedido_viagem_id']);

        $query = $this->db->get_where('gv_reserva_transporte', ['id' => $dados['id'], 'pedido_viagem_id' => $dados['pedido_viagem_id']])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Reserva de Transporte não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data) {
        $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        return $this->db->insert('gv_reserva_transporte', $data);
    }

    public function update($data, $id)  {
        $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id' => $id,
        ]);

        $this->db->where('id', $id);
        $this->db->update('gv_reserva_transporte', $data);

        return $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id' => $id
        ]);
    }

    public function delete ($dado) {
        $first = $this->first($dado);

        $this->db->where('id', $dado['id']);
        $this->db->delete('gv_reserva_transporte');

        return $first;
    }

    
    public function get_total()
	{
		$this->db->select('COUNT(*) AS total');
		$query = $this->db->get(db_prefix() . 'gv_reserva_transporte');
		return $query->row()->total; // Retorna um objeto com o total de registros
	}
    function obter_destinos_mais_visitados($limite = 10)
{
    $CI = &get_instance();
    $CI->db->select('local_destino, COUNT(local_destino) AS total_visitas');
    $CI->db->from(db_prefix() . 'gv_reserva_transporte');
    $CI->db->group_by('local_destino');
    $CI->db->order_by('total_visitas', 'DESC');
    $CI->db->limit($limite);
    $query = $CI->db->get();

    return $query->result_array(); // Retorna os dados como array associativo
}
}