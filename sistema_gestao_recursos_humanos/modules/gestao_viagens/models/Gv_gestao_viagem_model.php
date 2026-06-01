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

    public function verificar_ferias ($id) {
        $this->db->where('ano_fiscal', date('Y'));
        $this->db->where('func_id', $id);
        $query = $this->db->get('as_ferias')->result_array();
        $total_dias = 0;
        foreach ($query as $item) {
            $total_dias += $item['n_dias'];
        }
        return $total_dias;
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
    public function get_tipo_viagem_dashboard () {
        $query = $this->db->get('gv_tipo_viagem')->result_array();
        $cores = ['#336', '#DAA520', '#8B0000', '#ff0000', '#ffff00', '#00ffff'];
        $cores_hover = ['#36A2EB', '#FFCD56', '#FF6384', '#ff0000', '#ffff00', '#00ffff'];
        $label = '[';
        $count = '[';
        $background = '[';
        $backgroundhover = '[';
        $i = 0;
        foreach ($query as $q) {
            $total = $this->db->get_where('gv_pedido_viagem', ['tipo_viagem_id' => $q['id']])->num_rows();
            $label .= "'".$q['tipo_viagem']."',";
            $count .= "'".$total."',";

            $background .= "'".$cores[$i]."',";
            $backgroundhover .= "'".$cores_hover[$i]."',";
            $i++;
            if ($i >= 5) { $i = 0; }
        }
        $label .= ']';
        $count .= ']';
        $background .= ']';
        $backgroundhover .= ']';

        return [
            'label' => $label,
            'count' => $count,
            'background' => $background,
            'backgroundhover' => $backgroundhover,
        ];
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
        $total += $this->db->get_where('gv_pedido_viagem',  ['status_id' => $id])->num_rows();
        $total += $this->db->get_where('gv_estimativa_viagem',  ['status_id' => $id])->num_rows();
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

    // Reservas
    public function total_reserva($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gv_reserva')->num_rows();
        return $query;
    }
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
    public function total_orcamento($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gv_orcamento_viagem')->num_rows();
        return $query;
    }
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
    public function get_orcamento_grafico($status = null) {
        $this->db->select('
            gv_orcamento_viagem.*,
            gv_status.status,
            gv_tipo_viagem.tipo_viagem,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,

            gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,

            gv_estimativa_viagem.valor as valor_e,
        ');
        $this->db->from('gv_orcamento_viagem');
        $this->db->join('gv_status', 'gv_status.id = gv_orcamento_viagem.status_id', 'left');
        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');
        $this->db->join('gv_estimativa_viagem', 'gv_estimativa_viagem.id = gv_orcamento_viagem.estimativa_viagem_id', 'left');

        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');
        $this->db->join('gv_tipo_viagem', 'gv_tipo_viagem.id = gv_pedido_viagem.tipo_viagem_id', 'left');

        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        $this->db->where('gv_orcamento_viagem.status_id', 2);

        $query = $this->db->get()->result_array();
        $dados = [];
        $label = '[';
        $orcamento = '[';
        $estimativa = '[';
        foreach ($query as $o) {
            $label.= "'" . $o['objetivo'] . '(' . $o['destino'] . ')' . "',";
            $orcamento.= "'" . total_reserva($o) . "',";
            $estimativa.= "'" . $o['valor_e'] . "',";

            // $dados[] = [
            //     'viagem' => $o['objetivo'] . '(' . $o['destino'] . ')',
            //     'total' => total_reserva($o),
            //     'estimativa' => $o['valor_e']
            // ];
        }
        $label .= ']';
        $orcamento .= ']';
        $estimativa .= ']';

        // var_dump($label);
        // var_dump($orcamento);
        // var_dump($estimativa);
        // exit;

        return [
            'label' => $label,
            'orcamento' => $orcamento,
            'estimativa' => $estimativa,
        ];
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

    public function get_orcamento_hotel() {
        $this->db->select('
            gv_orcamento_viagem.id,
            gv_reserva.hotel_id,
            gv_hotel.preco,
        ');
        $this->db->from('gv_orcamento_viagem');
        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');
        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');

        $this->db->where('gv_orcamento_viagem.status_id', 2);
        $this->db->where('gv_reserva.status_id', 2);
        $this->db->where('gv_reserva.hotel_id <>', NULL);
        $query = $this->db->get()->result_array();
        $total = 0;
        foreach ($query as $t) {
            $total += $t['preco'];
        }
        return $total;
    }
    public function get_orcamento_voo() {
        $this->db->select('
            gv_orcamento_viagem.id,
            gv_reserva.voo_id,
            gv_voo.preco,
        ');
        $this->db->from('gv_orcamento_viagem');
        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');

        $this->db->where('gv_orcamento_viagem.status_id', 2);
        $this->db->where('gv_reserva.status_id', 2);
        $this->db->where('gv_reserva.voo_id <>', NULL);
        $query = $this->db->get()->result_array();
        $total = 0;
        foreach ($query as $t) {
            $total += $t['preco'];
        }
        return $total;
    }
    public function get_orcamento_transporte() {
        $this->db->select('
            gv_orcamento_viagem.id,
            gv_reserva.transporte_id,
            gv_transporte.preco,
        ');
        $this->db->from('gv_orcamento_viagem');
        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');

        $this->db->where('gv_orcamento_viagem.status_id', 2);
        $this->db->where('gv_reserva.status_id', 2);
        $this->db->where('gv_reserva.transporte_id <>', NULL);
        $query = $this->db->get()->result_array();
        $total = 0;
        foreach ($query as $t) {
            $total += $t['preco'];
        }
        return $total;
    }

    // Classificacoes
    public function total_classificacoes()
    {
        $query = $this->db->get('gv_classificacoes')->num_rows();
        return $query;
    }
    public function create_classificacoes($data)
    {
        $vfnivel_hierarquico = $this->db->get_where('gv_classificacoes', ['nome' => $data['nome']])->row_array();
        if ($vfnivel_hierarquico) {
            set_alert('danger',"Classificação já foi cadastrada");
            redirect('gestao_viagens/configuracoes?group=classificacoes');
        }
        return $this->db->insert('gv_classificacoes', $data);
    }
    public function get_classificacoes() {
        $query = $this->db->get('gv_classificacoes');
        return $query->result_array();
    }
    public function first_classificacoes($id) {
        $query = $this->db->get_where('gv_classificacoes', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_classificacoes ($data, $id) {
        $this->first_classificacoes($id);
        $vf = $this->db->get_where('gv_classificacoes', ['nome' => $data['nome']])->row_array();
        if ($vf) {
            if ($id != $vf['id']) {
                set_alert('danger',"Classificação já foi cadastrada");
			    redirect('gestao_viagens/configuracoes?group=classificacoes');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_classificacoes', $data);
        return $this->first_classificacoes($id);
    }
    public function delete_classificacoes($id) {
        $first = $this->first_classificacoes($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_classificacoes');
        return $first;
    }

    public function get_categorias_despesas () {
        return $this->db->get('gv_categoria_despesa')->result_array();
    }
    public function create_categoria_despesas($data)
    {
        $vf_existe = $this->db->get_where('gv_categoria_despesa', ['categoria' => $data['categoria']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Categoria já foi cadastrada");
            redirect('gestao_viagens/configuracoes?group=categorias_despesas');
        }
        return $this->db->insert('gv_categoria_despesa', $data);
    }
    public function first_categoria_despesas($id) {
        $query = $this->db->get_where('gv_categoria_despesa', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_categoria_despesas ($data, $id) {
        $this->first_categoria_despesas($id);
        $vf_existe = $this->db->get_where('gv_categoria_despesa', ['categoria' => $data['categoria']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Categoria já foi cadastrada");
			    redirect('gestao_viagens/configuracoes?group=categorias_despesas');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_categoria_despesa', $data);

        return $this->first_categoria_despesas($id);
    }
    public function delete_categoria_despesas($id) {
        $first = $this->first_categoria_despesas($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_pedido_viagem',  ['categoria_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Pedido de Viagem associada com esta Categória");
		//  	redirect('gestao_viagens/configuracoes?group=categorias_despesas');
        // }
        $this->db->where('id', $id);
        $this->db->delete('gv_categoria_despesa');
        return $first;
    }

    public function get_despesa($limit = NULL, $offset = null, $pesquisa = null)
    {
        $this->db->select('
            gv_despesas.*,
            gv_categoria_despesa.categoria,
            gv_status.status,
            gv_orcamento_viagem.reserva_id, gv_orcamento_viagem.aprovadores,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,

            gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_despesas');
        $this->db->join('gv_categoria_despesa', 'gv_categoria_despesa.id = gv_despesas.categoria_despesa_id', 'left');
        $this->db->join('gv_status', 'gv_status.id = gv_despesas.status_id', 'left');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_despesas.orcamento_viagem_id', 'left');

        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');

        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');

        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        // $this->db->where('gv_decisao_viagem.status', $status);
        if ($limit) {
            if ($offset) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }
        if ($pesquisa) {
            $this->db->like('gv_pedido_viagem.objetivo', $pesquisa);
            $this->db->or_like('gv_pedido_viagem.destino', $pesquisa);
        }
        // $query = $this->db->get('gv_pedido_viagem');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first_despesa($id)
    {
        $this->db->select('
            gv_despesas.*,
            gv_categoria_despesa.categoria,
            gv_status.status,
            gv_orcamento_viagem.reserva_id, gv_orcamento_viagem.aprovadores,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,

            gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_despesas');
        $this->db->join('gv_categoria_despesa', 'gv_categoria_despesa.id = gv_despesas.categoria_despesa_id', 'left');
        $this->db->join('gv_status', 'gv_status.id = gv_despesas.status_id', 'left');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_despesas.orcamento_viagem_id', 'left');

        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');

        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');

        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        $this->db->where('gv_despesas.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function create_despesa($data)
    {
        return $this->db->insert('gv_despesas', $data);
    }
    public function update_despesa ($data, $id) {
        $this->first_despesa($id);
        $this->db->where('id', $id);
        $this->db->update('gv_despesas', $data);

        return $this->first_despesa($id);
    }
    public function delete_despesa($id) {
        $first = $this->first_despesa($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_despesas');
        return $first;
    }
    public function update_despesa_status($data, $id)
    {
        $this->Gv_gestao_viagem_model->first_status($data['status_id']);

        $this->db->where('id', $id);
        $this->db->update('gv_despesas', $data);

        return $this->first_despesa($id);
    }

    public function get_tipo_comunicacao () {
        return $this->db->get('gv_tipo_comunicacao')->result_array();
    }
    public function create_tipo_comunicacao($data)
    {
        $vf_existe = $this->db->get_where('gv_tipo_comunicacao', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Tipo de Comunicação já foi cadastrada");
            redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
        }
        return $this->db->insert('gv_tipo_comunicacao', $data);
    }
    public function first_tipo_comunicacao($id) {
        $query = $this->db->get_where('gv_tipo_comunicacao', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_tipo_comunicacao ($data, $id) {
        $this->first_tipo_comunicacao($id);
        $vf_existe = $this->db->get_where('gv_tipo_comunicacao', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Tipo de Viagem já foi cadastrada");
			    redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_tipo_comunicacao', $data);

        return $this->first_tipo_comunicacao($id);
    }
    public function delete_tipo_comunicacao($id) {
        $first = $this->first_tipo_comunicacao($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_pedido_viagem',  ['tipo_viagem_id' => $id])->num_rows();
        // $total += $this->db->get_where('gv_estimativa_viagem',  ['tipo_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Entidades associadas com esea Tipo de Viagem");
		//  	redirect('gestao_viagens/configuracoes?group=tipo_viagem');
        // }
        $this->db->where('id', $id);
        $this->db->delete('gv_tipo_comunicacao');
        return $first;
    }

    public function ultimo_comunicacao_id($data) {
        $this->db->where('orcamento_viagem_id', $data['orcamento_viagem_id']);
        $this->db->where('tipo_comunicacao_id', $data['tipo_comunicacao_id']);
        $this->db->where('data_envio', $data['data_envio']);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('gv_comunicacao_viagem');
        return $query->row_array();

    }
    public function delete_comunicacao_staff($id, $ids_staffs) {
        $this->db->select('*');
        $this->db->from('gv_staff_comunicacao');
        $this->db->where('comunicacao_viagem_id', $id);
        $this->db->where_not_in('staff_id', $ids_staffs);
        return $this->db->delete();
    }
    public function get_comunicacao_staff($id) {
        $this->db->select('
            gv_staff_comunicacao.*,
            staff.*,
        ');
        $this->db->from('gv_staff_comunicacao');
        $this->db->join('staff', 'staff.staffid = gv_staff_comunicacao.staff_id', 'right');
        $this->db->where('comunicacao_viagem_id', $id);
        return $this->db->get()->result_array();
    }
    public function get_comunicacao($limit = NULL, $offset = null, $pesquisa = null)
    {
        $this->db->select('
            gv_comunicacao_viagem.*,
            gv_tipo_comunicacao.nome as tipo_comunicacao,
            gv_orcamento_viagem.reserva_id, gv_orcamento_viagem.aprovadores,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,

            gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_comunicacao_viagem');
        $this->db->join('gv_tipo_comunicacao', 'gv_tipo_comunicacao.id = gv_comunicacao_viagem.tipo_comunicacao_id', 'left');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_comunicacao_viagem.orcamento_viagem_id', 'left');

        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');

        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');

        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        // $this->db->where('gv_decisao_viagem.status', $status);
        if ($limit) {
            if ($offset) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }
        if ($pesquisa) {
            $this->db->like('gv_pedido_viagem.objetivo', $pesquisa);
            $this->db->or_like('gv_pedido_viagem.destino', $pesquisa);
        }
        // $query = $this->db->get('gv_pedido_viagem');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first_comunicacao($id)
    {
        $this->db->select('
            gv_comunicacao_viagem.*,
            gv_tipo_comunicacao.nome as tipo_comunicacao,
            gv_orcamento_viagem.reserva_id, gv_orcamento_viagem.aprovadores,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,

            gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
            gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
            gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
            gv_voo.nome as voo, gv_voo.preco as preco_v,
        ');
        $this->db->from('gv_comunicacao_viagem');
        $this->db->join('gv_tipo_comunicacao', 'gv_tipo_comunicacao.id = gv_comunicacao_viagem.tipo_comunicacao_id', 'left');
        $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_comunicacao_viagem.orcamento_viagem_id', 'left');

        $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');

        $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');

        $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
        $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
        $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');
        $this->db->where('gv_comunicacao_viagem.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function create_comunicacao_staff($dados) {
        $query = $this->db->get_where('gv_staff_comunicacao', ['staff_id' => $dados['staff_id'], 'comunicacao_viagem_id' => $dados['comunicacao_viagem_id']])->row_array();
        if (!$query) {
            return $this->db->insert('gv_staff_comunicacao', $dados);
        }
    }
    public function create_comunicacao($data, $funcionarios)
    {
        $inserir = $this->db->insert('gv_comunicacao_viagem', $data);
        if ($inserir) {
            $id = $this->ultimo_comunicacao_id($data);

            foreach ($funcionarios as $a) {
                $this->create_comunicacao_staff([
                    'staff_id' => $a,
                    'comunicacao_viagem_id' => $id['id']
                ]);
            }
        }
    }
    public function update_comunicacao ($data, $funcionarios, $id) {
        $this->first_comunicacao($id);
        $this->db->where('id', $id);
        $this->db->update('gv_comunicacao_viagem', $data);

        $this->delete_comunicacao_staff($id, $funcionarios);
        foreach ($funcionarios as $a) {
            $this->create_comunicacao_staff([
                'staff_id' => $a,
                'comunicacao_viagem_id' => $id
            ]);
        }

        return $this->first_comunicacao($id);
    }
    public function delete_comunicacao($id) {
        $first = $this->first_comunicacao($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_comunicacao_viagem');
        return $first;
    }
}