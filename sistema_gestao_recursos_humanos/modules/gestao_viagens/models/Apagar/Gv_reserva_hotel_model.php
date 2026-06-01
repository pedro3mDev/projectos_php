<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_reserva_hotel_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
    }

    public function get($id)
    {
        $this->Gv_pedido_model->first($id);

        $this->db->select('gv_reserva_hotel.*, gv_status.status');
        $this->db->from('gv_reserva_hotel');
        $this->db->join('gv_status', 'gv_status.id = gv_reserva_hotel.status_id', 'right');
        $this->db->where('gv_reserva_hotel.pedido_viagem_id', $id);

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function first($dados)
    {
        if (!isset($dados['pedido_viagem_id']) or !isset($dados['id'])) {
            show_404();
            exit;
        }
        $this->Gv_pedido_model->first($dados['pedido_viagem_id']);

        $query = $this->db->get_where('gv_reserva_hotel', ['id' => $dados['id'], 'pedido_viagem_id' => $dados['pedido_viagem_id']])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }

    public function create($data)
    {
        $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        return $this->db->insert('gv_reserva_hotel', $data);
    }

    public function update($data, $id)
    {
        $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id' => $id,
        ]);

        $this->db->where('id', $id);
        $this->db->update('gv_reserva_hotel', $data);

        return $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id' => $id
        ]);
    }

    public function delete($dado)
    {
        $first = $this->first($dado);

        $this->db->where('id', $dado['id']);
        $this->db->delete('gv_reserva_hotel');

        return $first;
    }

    public function get_total()
    {
        $this->db->select('COUNT(*) AS total');
        $query = $this->db->get(db_prefix() . 'gv_reserva_hotel');
        return $query->row()->total; // Retorna um objeto com o total de registros
    }
    function obter_destinos_mais_visitados($limite = 10)
    {
        $CI = &get_instance();
        $CI->db->select('destino, COUNT(destino) AS total_visitas');
        $CI->db->from(db_prefix() . 'gv_reserva_hotel');
        $CI->db->group_by('destino');
        $CI->db->order_by('total_visitas', 'DESC');
        $CI->db->limit($limite);
        $query = $CI->db->get();

        return $query->result_array(); // Retorna os dados como array associativo
    }
}
