<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_gestao_viagem_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function staffs() {
        $query = $this->db->get_where('staff', ['active' => 1]);
        return $query->result_array();
    }
    public function staffs_admin() {
        $query = $this->db->get_where('staff', [
            'admin' => 1,
            'active' => 1,
        ]);
        return $query->result_array();
    }

    public function get_categorias () {
        return $this->db->get('gv_categoria')->result_array();
    }
    public function create_categoria($data)
    {
        $vf_existe = $this->db->get_where('gv_categoria', ['categoria' => $data['categoria']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Categoria já foi cadastrada");
            redirect('gestao_viagens/configuracoes?group=categorias');
        }
        return $this->db->insert('gv_categoria', $data);
    }
    public function first_categoria($id) {
        $query = $this->db->get_where('gv_categoria', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_categoria ($data, $id) {
        $this->first_categoria($id);
        $vf_existe = $this->db->get_where('gv_categoria', ['categoria' => $data['categoria']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Categoria já foi cadastrada");
			    redirect('gestao_viagens/configuracoes?group=categorias');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_categoria', $data);

        return $this->first_categoria($id);
    }
    public function delete_categoria($id) {
        $first = $this->first_categoria($id);

        $total = 0;
        $total += $this->db->get_where('gv_pedido_viagem',  ['categoria_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Pedido de Viagem associada com esta Categória");
		 	redirect('gestao_viagens/configuracoes?group=categorias');
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_categoria');
        return $first;
    }

    public function get_tipo_viagem () {
        return $this->db->get('gv_tipo_viagem')->result_array();
    }
    public function create_tipo_viagem($data)
    {
        $vf_existe = $this->db->get_where('gv_tipo_viagem', ['tipo_viagem' => $data['tipo_viagem']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Tipo de Viagem já foi cadastrada");
            redirect('gestao_viagens/configuracoes?group=tipo_viagem');
        }
        return $this->db->insert('gv_tipo_viagem', $data);
    }
    public function first_tipo_viagem($id) {
        $query = $this->db->get_where('gv_tipo_viagem', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_tipo_viagem ($data, $id) {
        $this->first_tipo_viagem($id);
        $vf_existe = $this->db->get_where('gv_tipo_viagem', ['tipo_viagem' => $data['tipo_viagem']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Tipo de Viagem já foi cadastrada");
			    redirect('gestao_viagens/configuracoes?group=tipo_viagem');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_tipo_viagem', $data);

        return $this->first_tipo_viagem($id);
    }
    public function delete_tipo_viagem($id) {
        $first = $this->first_tipo_viagem($id);

        $total = 0;
        $total += $this->db->get_where('gv_pedido_viagem',  ['tipo_viagem_id' => $id])->num_rows();
        $total += $this->db->get_where('gv_estimativa_viagem',  ['tipo_viagem_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Entidades associadas com esea Tipo de Viagem");
		 	redirect('gestao_viagens/configuracoes?group=tipo_viagem');
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_tipo_viagem');
        return $first;
    }

    public function get_status () {
        return $this->db->get('gv_status')->result_array();
    }
    public function create_status($data)
    {
        $vf_existe = $this->db->get_where('gv_status', ['status' => $data['status']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Tipo de Viagem já foi cadastrada");
            redirect('gestao_viagens/configuracoes?group=status');
        }
        return $this->db->insert('gv_status', $data);
    }
    public function first_status($id) {
        $query = $this->db->get_where('gv_status', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_status ($data, $id) {
        $this->first_status($id);
        $vf_existe = $this->db->get_where('gv_status', ['status' => $data['status']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Status já foi cadastrada");
			    redirect('gestao_viagens/configuracoes?group=status');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_status', $data);

        return $this->first_status($id);
    }
    public function delete_status($id) {
        $first = $this->first_status($id);

        $total = 0;
        $total += $this->db->get_where('gv_pedido_viagem',  ['sstatus_id' => $id])->num_rows();
        $total += $this->db->get_where('gv_estimativa_viagem',  ['sstatus_id' => $id])->num_rows();
        if ($total) {
            show_404();
            exit;
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_status');
        return $first;
    }

    // Estimativa
    public function create_estimativa($data)
    {
        $this->first_tipo_viagem($data['tipo_viagem_id']);
        $vf_existe = $this->db->get_where('gv_estimativa_viagem', [
            'tipo_viagem_id' => $data['tipo_viagem_id'],
            'valor' => $data['valor'],
        ])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Estimativa de Viagem já foi cadastrado");
            redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
        }
        return $this->db->insert('gv_estimativa_viagem', $data);
    }
    public function get_estimativa () {
        $this->db->select('
            gv_estimativa_viagem.*,
            gv_tipo_viagem.tipo_viagem,
        ');
        $this->db->from('gv_estimativa_viagem');
        $this->db->join('gv_tipo_viagem', 'gv_tipo_viagem.id = gv_estimativa_viagem.tipo_viagem_id', 'left');
        return $this->db->get()->result_array();
    }
    public function first_estimativa ($id) {
        $query = $this->db->get_where('gv_estimativa_viagem', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_estimativa ($data, $id) {
        $this->first_estimativa($id);
        $vf_existe = $this->db->get_where('gv_estimativa_viagem', [
            'tipo_viagem_id' => $data['tipo_viagem_id'],
            'valor' => $data['valor'],
        ])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Estimativa de Viagem já foi cadastrado");
			    redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_estimativa_viagem', $data);
        return $this->first_estimativa($id);
    }
    public function delete_estimativa($id) {
        $first = $this->first_status($id);

        // $vfpolitica = true;
        // if ($vfpolitica) {
        //     set_alert('danger',"Existe Politica associada com este Nivel Hierarquico");
		// 	redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
        // }
        $this->db->where('id', $id);
        $this->db->delete('gv_estimativa_viagem');
        return $first;
    }


    public function create_voo($data)
    {
        return $this->db->insert('gv_voo', $data);
    }
    public function get_voos ($status = null) {
        $this->db->select('
            gv_voo.*,
            gv_status.status,
        ');
        $this->db->from('gv_voo');
        $this->db->join('gv_status', 'gv_status.id = gv_voo.status_id', 'left');
        if ($status) {
            $this->db->where('gv_voo.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function first_voo($id) {
        $query = $this->db->get_where('gv_voo', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function first_voo_b($id) {
        $query = $this->db->get_where('gv_voo', ['id' => $id])->row_array();
        if (!$query) {
            return false;
        }
        return $query;
    }
    public function update_voo ($data, $id) {
        $this->first_voo($id);
        $this->db->where('id', $id);
        $this->db->update('gv_voo', $data);

        return $this->first_voo($id);
    }
    public function delete_voo($id) {
        $first = $this->first_voo($id);

        $total = 0;
        $total += $this->db->get_where('gv_reserva',  ['voo_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Reserva associadas com este Voo");
		 	redirect('gestao_viagens/pedidos/reservas/?group=voo');
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_voo');
        return $first;
    }

    // Hotel
    public function create_hotel($data)
    {
        return $this->db->insert('gv_hotel', $data);
    }
    public function get_hotel ($status = null) {
        $this->db->select('
            gv_hotel.*,
            gv_status.status,
        ');
        $this->db->from('gv_hotel');
        $this->db->join('gv_status', 'gv_status.id = gv_hotel.status_id', 'left');
        if ($status) {
            $this->db->where('gv_hotel.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function first_hotel($id) {
        $query = $this->db->get_where('gv_hotel', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function first_hotel_b($id) {
        $query = $this->db->get_where('gv_hotel', ['id' => $id])->row_array();
        if (!$query) {
            return false;
        }
        return $query;
    }
    public function update_hotel ($data, $id) {
        $this->first_hotel($id);
        $this->db->where('id', $id);
        $this->db->update('gv_hotel', $data);

        return $this->first_hotel($id);
    }
    public function delete_hotel($id) {
        $first = $this->first_hotel($id);

        $total = 0;
        $total += $this->db->get_where('gv_reserva',  ['hotel_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Reserva associadas com este Hotel");
		 	redirect('gestao_viagens/pedidos/reservas/?group=hotel');
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_hotel');
        return $first;
    }

    // Transporte
    public function create_transporte($data)
    {
        return $this->db->insert('gv_transporte', $data);
    }
    public function get_transporte ($status = null) {
        $this->db->select('
            gv_transporte.*,
            gv_status.status,
        ');
        $this->db->from('gv_transporte');
        $this->db->join('gv_status', 'gv_status.id = gv_transporte.status_id', 'left');
        if ($status) {
            $this->db->where('gv_transporte.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function first_transporte($id) {
        $query = $this->db->get_where('gv_transporte', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function first_transporte_b($id) {
        $query = $this->db->get_where('gv_transporte', ['id' => $id])->row_array();
        if (!$query) {
            return false;
        }
        return $query;
    }
    public function update_transporte ($data, $id) {
        $this->first_transporte($id);
        $this->db->where('id', $id);
        $this->db->update('gv_transporte', $data);

        return $this->first_transporte($id);
    }
    public function delete_transporte($id) {
        $first = $this->first_transporte($id);

        $total = 0;
        $total += $this->db->get_where('gv_reserva',  ['transporte_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Reserva associadas com este Transporte");
		 	redirect('gestao_viagens/pedidos/reservas/?group=transporte');
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_transporte');
        return $first;
    }

    // Transporte
    public function create_reserva($data)
    {
        return $this->db->insert('gv_reserva', $data);
    }
    public function get_reserva ($status = null) {
        $this->db->select('
            gv_reserva.*,
            gv_status.status,
            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_reserva');
        $this->db->join('gv_status', 'gv_status.id = gv_reserva.status_id', 'left');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');
        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        if ($status) {
            $this->db->where('gv_reserva.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function first_reserva ($id) {
        $this->db->select('
            gv_reserva.*,
            gv_status.status,
            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_reserva');
        $this->db->join('gv_status', 'gv_status.id = gv_reserva.status_id', 'left');
        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');
        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        $this->db->where('gv_reserva.id', $id);
        return $this->db->get()->row_array();
    }
    public function update_reserva ($data, $id) {
        $this->first_reserva($id);
        $this->db->where('id', $id);
        $this->db->update('gv_reserva', $data);

        return $this->first_reserva($id);
    }
    public function delete_reserva($id) {
        $first = $this->first_reserva($id);

        $total = 0;
        $total += $this->db->get_where('gv_orcamento_viagem',  ['reserva_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Orçamento associadas a esta Reserva");
		 	redirect('gestao_viagens/pedidos/reservas/?group=reservas');
        }
        $this->db->where('id', $id);
        $this->db->delete('gv_reserva');
        return $first;
    }

    // Orcamento
    public function create_orcamento($data)
    {
        $query = $this->db->get_where('gv_orcamento_viagem', [
            'status_id' => 1,
            'reserva_id' => $data['reserva_id'],
        ])->row_array();
        if ($query) {
            set_alert('danger',"Já existe Orçamento associadas com esatdo pendente");
		 	redirect('gestao_viagens/orcamentos');
        }
        $query = $this->db->get_where('gv_orcamento_viagem', [
            'status_id' => 2,
            'reserva_id' => $data['reserva_id'],
        ])->row_array();
        if ($query) {
            set_alert('danger',"Já existe Orçamento associadas com esatdo activo");
		 	redirect('gestao_viagens/orcamentos');
        }
        return $this->db->insert('gv_orcamento_viagem', $data);
    }
    public function get_orcamento($status = null) {
        $this->db->select('
            gv_orcamento_viagem.*,
            gv_status.status,
            gv_tipo_viagem.tipo_viagem,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,

            gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_orcamento_viagem');
        $this->db->join('gv_status', 'gv_status.id = gv_orcamento_viagem.status_id', 'left');
        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');

        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');
        $this->db->join('gv_tipo_viagem', 'gv_tipo_viagem.id = gv_pedido_viagem.tipo_viagem_id', 'left');

        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        if ($status) {
            $this->db->where('gv_orcamento_viagem.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function first_orcamento($id) {
        $query = $this->db->get_where('gv_orcamento_viagem', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_orcamento ($data, $id) {
        $this->first_orcamento($id);

        $query = $this->db->get_where('gv_orcamento_viagem', [
            'status_id' => 1,
            'reserva_id' => $data['reserva_id'],
        ])->row_array();
        if ($query) {
            if ($query['id'] != $id) {
                set_alert('danger',"Já existe Orçamento associadas com esatdo pendente");
                redirect('gestao_viagens/orcamentos');
            }
        }
        $query = $this->db->get_where('gv_orcamento_viagem', [
            'status_id' => 2,
            'reserva_id' => $data['reserva_id'],
        ])->row_array();
        if ($query) {
            if ($query['id'] != $id) {
                set_alert('danger',"Já existe Orçamento associadas com esatdo activo");
                redirect('gestao_viagens/orcamentos');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_orcamento_viagem', $data);
        return $this->first_orcamento($id);
    }
    public function delete_orcamento($id) {
        $first = $this->first_reserva($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_orcamento_viagem');
        return $first;
    }
}