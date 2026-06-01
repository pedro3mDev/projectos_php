<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_orcamento_viagem_model extends App_Model
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
        $this->db->from('gv_orcamento_viagem');
        $query = $this->db->get();
        return array_column($query->result_array(), 'pedido_viagem_id');
    }

    public function get()
    {
        // $this->db->select('gv_pedido_viagem.id, gv_pedido_viagem.status_id, gv_pedido_viagem.tipo_viagem, gv_pedido_viagem.objetivo, gv_pedido_viagem.destino,  gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim, gv_pedido_viagem.data_criacao, gv_pedido_viagem.data_actualizacao');
        // $this->db->select('gv_pedido_viagem.*, gv_orcamento_viagem.id as pedido_orcamento_id, gv_orcamento_viagem.orcamento');
        // $this->db->from('gv_orcamento_viagem');
        // $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_orcamento_viagem.pedido_viagem_id');
        // $this->db->where('orcamento_viagem.status', $status);
        
        
        
        
        $this->db->select('gv_pedido_viagem.*, gv_decisao_viagem.decisao, gv_orcamento_viagem.id as orcamento_pedido_id, gv_orcamento_viagem.orcamento');
        $this->db->from('gv_decisao_viagem');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_decisao_viagem.pedido_viagem_id', 'right');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.pedido_viagem_id = gv_pedido_viagem.id', 'right');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function total_dispesa($id) {
        $this->db->select_sum('valor');
        $this->db->where('id_pedido_viagem', $id);
        $query = $this->db->get('gv_despesas');
        return $query->row()->valor ?? 0;
    }
    public function total_reserva_hotel($id) {
        $this->db->select_sum('valor');
        $this->db->where('pedido_viagem_id', $id);
        $query = $this->db->get('gv_reserva_hotel');
        return $query->row()->valor ?? 0;
    }
    public function total_reserva_voo($id) {
        $this->db->select_sum('valor');
        $this->db->where('pedido_viagem_id', $id);
        $query = $this->db->get('gv_reserva_voo');
        return $query->row()->valor ?? 0;
    }
    public function total_reserva_transporte($id) {
        $this->db->select_sum('valor');
        $this->db->where('pedido_viagem_id', $id);
        $query = $this->db->get('gv_reserva_transporte');
        return $query->row()->valor ?? 0;
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
        $this->db->from('gv_status_pedido');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_status_pedido.pedido_viagem_id');
        $this->db->where('gv_status_pedido.status', $status);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    public function total_pendente() {
        $ids_pedido = $this->verificados();
        $this->db->select('id, status_id, tipo_viagem, objetivo, destino, data_inicio, data_fim, data_criacao, data_actualizacao');
        $this->db->from('gv_pedido_viagem');
        if ($ids_pedido) {
            $this->db->where_not_in('id', $ids_pedido);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    public function first($id) {
        // $query = $this->db->get_where('gv_orcamento_viagem', ['id' => $id])->row_array();
        $this->db->select('gv_pedido_viagem.*, gv_orcamento_viagem.id as pedido_orcamento_id, gv_orcamento_viagem.orcamento');
        $this->db->from('gv_orcamento_viagem');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_orcamento_viagem.pedido_viagem_id');
        $this->db->where('gv_orcamento_viagem.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Orçamento de Viagem não encontrado']);
            exit;
        }
        return $query;
    }
    public function first_pedido($id) {
        $query = $this->db->get_where('gv_orcamento_viagem', ['pedido_viagem_id' => $id])->row_array();
        return $query;
    }

    public function geral($id) {
        $this->Gv_pedido_model->first($id);

        $vfOrcamento = $this->db->get_where('gv_orcamento_viagem', ['pedido_viagem_id' => $id])->row_array();
        $total_despesas = $this->total_dispesa($id) + $this->total_reserva_hotel($id) + $this->total_reserva_voo($id) + $this->total_reserva_transporte($id);

        if ($vfOrcamento) {
            $orcamento = $vfOrcamento['orcamento'];
            $diferenca = $orcamento - $total_despesas;
        }
        else {
            $orcamento = 'Não Definido';
            $diferenca = 'Diferença requer o orçamento';
        }
        $data = [
            'total_despesa' => $this->total_dispesa($id),
            'total_reserva_hotel' => $this->total_reserva_hotel($id),
            'total_reserva_voo' => $this->total_reserva_voo($id),
            'total_reserva_transporte' => $this->total_reserva_transporte($id),
            'orcamento' => $orcamento,
            'diferenca' => $diferenca,
        ];
        return $data;
    }

    public function create($data) {
        $this->Gv_pedido_model->first($data['pedido_viagem_id']);
        $vfOrcamento = $this->db->get_where('gv_orcamento_viagem', ['pedido_viagem_id' => $data['pedido_viagem_id']])->row_array();
        if ($vfOrcamento) {
            return false;
        }
        return $this->db->insert('gv_orcamento_viagem', $data);
    }

    public function update($data, $id)  {
        $this->first($id);

        $this->db->where('id', $id);
        $this->db->update('gv_orcamento_viagem', $data);

        return $this->first($id);
    }

    public function delete ($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_orcamento_viagem');

        return $first;
    }
}