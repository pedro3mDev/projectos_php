<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_pedido_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Gv_gestao_viagem_model');
    }

    public function total($filtro = null)
    {
        if ($filtro != null and $filtro != 'nacional' and $filtro != 'internacional') {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['status' => false, 'message' => 'Página não Encontrada']);
            exit;
        }
        if ($filtro != null) {
            $this->db->where('tipo_viagem_id', $filtro);
        }

        $query = $this->db->get('gv_pedido_viagem')->num_rows();
        return $query;
    }

    public function get($limit = NULL, $offset = null, $pesquisa = null)
    {
        $this->db->select('
            gv_pedido_viagem.*,
            gv_categoria.categoria,
            gv_status.status,
            gv_tipo_viagem.tipo_viagem,
        ');
        $this->db->from('gv_pedido_viagem');
        $this->db->join('gv_categoria', 'gv_categoria.id = gv_pedido_viagem.categoria_id', 'lefr');
        $this->db->join('gv_status', 'gv_status.id = gv_pedido_viagem.status_id', 'lefr');
        $this->db->join('gv_tipo_viagem', 'gv_tipo_viagem.id = gv_pedido_viagem.tipo_viagem_id', 'lefr');
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
    public function get_status($status = NULL)
    {
        $this->db->select('
            gv_pedido_viagem.*,
            gv_categoria.categoria,
            gv_status.status,
            gv_tipo_viagem.tipo_viagem,
        ');
        $this->db->from('gv_pedido_viagem');
        $this->db->join('gv_categoria', 'gv_categoria.id = gv_pedido_viagem.categoria_id', 'right');
        $this->db->join('gv_status', 'gv_status.id = gv_pedido_viagem.status_id', 'right');
        $this->db->join('gv_tipo_viagem', 'gv_tipo_viagem.id = gv_pedido_viagem.tipo_viagem_id', 'right');
        if ($status) {
            $this->db->where('gv_pedido_viagem.status_id', $status);
        }
        return $this->db->get()->result_array();
    }

    public function get_staff($id) {
        $this->db->select('
            gv_staff_viagem.*,
            staff.*,
        ');
        $this->db->from('gv_staff_viagem');
        $this->db->join('staff', 'staff.staffid = gv_staff_viagem.staff_id', 'right');
        $this->db->where('pedido_viagem_id', $id);
        return $this->db->get()->result_array();
    }

    public function first($id)
    {
        $this->db->select('
            gv_pedido_viagem.*,
            gv_categoria.categoria,
            gv_status.status,
            gv_tipo_viagem.tipo_viagem,
        ');
        $this->db->from('gv_pedido_viagem');
        $this->db->join('gv_categoria', 'gv_categoria.id = gv_pedido_viagem.categoria_id', 'right');
        $this->db->join('gv_status', 'gv_status.id = gv_pedido_viagem.status_id', 'right');
        $this->db->join('gv_tipo_viagem', 'gv_tipo_viagem.id = gv_pedido_viagem.tipo_viagem_id', 'right');
        $this->db->where('gv_pedido_viagem.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }

    public function ultimo_id($data) {
        // $this->db->where([
        //     'tipo_viagem_id' => $data['tipo_viagem_id'],
        //     'status_id' => $data['status_id'],
        //     'categoria_id' => $data['categoria_id'],
        //     'staff_id' => $data['staff_id'],
        // ]);
        $this->db->where('tipo_viagem_id', $data['tipo_viagem_id']);
        $this->db->where('status_id', $data['status_id']);
        $this->db->where('categoria_id', $data['categoria_id']);
        $this->db->where('staff_id', $data['staff_id']);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('gv_pedido_viagem');
        return $query->row_array();

    }

    public function delete_staff($id, $ids_staffs) {

        $this->db->select('*');
        $this->db->from('gv_staff_viagem');
        $this->db->where_not_in('staff_id', $ids_staffs);
        return $this->db->delete();
    }
    public function create_staff($dados) {
        $query = $this->db->get_where('gv_staff_viagem', ['staff_id' => $dados['staff_id'], 'pedido_viagem_id' => $dados['pedido_viagem_id']])->row_array();
        if (!$query) {
            return $this->db->insert('gv_staff_viagem', $dados);
        }
    }

    public function create($data, $funcionarios)
    {
        $this->Gv_gestao_viagem_model->first_tipo_viagem($data['tipo_viagem_id']);
        $this->Gv_gestao_viagem_model->first_categoria($data['categoria_id']);
        $inserir = $this->db->insert('gv_pedido_viagem', $data);
        if ($inserir) {
            $id = $this->ultimo_id($data);

            foreach ($funcionarios as $a) {
                $this->create_staff([
                    'staff_id' => $a,
                    'pedido_viagem_id' => $id['id']
                ]);
            }
        }
    }
    public function update($data, $funcionarios, $id)
    {
        $this->Gv_gestao_viagem_model->first_tipo_viagem($data['tipo_viagem_id']);
        $this->Gv_gestao_viagem_model->first_categoria($data['categoria_id']);

        $this->db->where('id', $id);
        $this->db->update('gv_pedido_viagem', $data);

        // Eliminar os Funcionarios que nao existem e adicionar os novos
        $this->delete_staff($id, $funcionarios);
        foreach ($funcionarios as $a) {
            $this->create_staff([
                'staff_id' => $a,
                'pedido_viagem_id' => $id
            ]);
        }
        return $this->first($id);
    }
    public function update_status($data, $id)
    {
        $this->Gv_gestao_viagem_model->first_status($data['status_id']);

        $this->db->where('id', $id);
        $this->db->update('gv_pedido_viagem', $data);

        return $this->first($id);
    }

    public function delete($id)
    {
        $first = $this->first($id);

        $total = 0;
        $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        if ($total) {
            set_alert('danger',"Existe Reserva associadas com este Pedido");
		 	redirect('gestao_viagens/pedidos');
        }

        $this->db->where('id', $id);
        $this->db->delete('gv_pedido_viagem');

        return $first;
    }













    public function get_total()
	{
		$this->db->select('COUNT(*) AS total');
		$query = $this->db->get(db_prefix() . 'gv_pedido_viagem');
		return $query->row()->total; // Retorna um objeto com o total de registros
	}
    public function get_total_pedidos_by_type($type)
	{
		// Verifica se o status foi passado corretamente
		if (!in_array($type, ["nacional","internacional"])) {
			return 0; // Retorna 0 se o status não for válido
		}

		// Realiza a consulta para contar as campanhas com o status fornecido
		$this->db->select('COUNT(*) AS total_pedidos');
		$this->db->where('tipo_viagem', $type);
		$query = $this->db->get(db_prefix() . 'gv_pedido_viagem');

		// Retorna o total de campanhas para o status específico
		return $query->row()->total_pedidos;
	}
    public function get_all_total_pedidos()
    {
        $total = $this->get_total();
        $nacional = $this->get_total_pedidos_by_type("nacional");
        $internacional = $this->get_total_pedidos_by_type("internacional");

        // Combina todos os dados em um array
        return [
            'total' => $total,
            'internacional' => $internacional,
            'nacional' => $nacional,
        ];
    }
}