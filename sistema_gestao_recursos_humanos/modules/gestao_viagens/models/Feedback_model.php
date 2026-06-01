<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback_model extends CI_Model
{
  // Nome da tabela
  private $table = 'tblgv_reletorio_feedback';

  public function total()
  {
    $query = $this->db->get('gv_reletorio_feedback')->num_rows();
    return $query;
  }
  public function get($limit = NULL, $offset = null, $pesquisa = null)
  {
      $this->db->select('
          gv_reletorio_feedback.*,
          gv_classificacoes.nome as classificacao,
          gv_orcamento_viagem.estimativa_viagem_id,

          gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
          gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
          gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
          gv_voo.nome as voo, gv_voo.preco as preco_v,

            gv_pedido_viagem.objetivo, gv_pedido_viagem.destino, gv_pedido_viagem.data_inicio, gv_pedido_viagem.data_fim,
      ');
      $this->db->from('gv_reletorio_feedback');
      $this->db->join('gv_classificacoes', 'gv_classificacoes.id = gv_reletorio_feedback.classificacao_id', 'left');
      $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_reletorio_feedback.orcamento_viagem_id', 'left');

      $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');
      $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
      $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
      $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');

      $this->db->join('gv_pedido_viagem', 'gv_pedido_viagem.id = gv_reserva.pedido_viagem_id', 'left');
      if ($limit) {
        if ($offset) {
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);
        }
      }
      // $query = $this->db->get('gv_pedido_viagem');
      $query = $this->db->get()->result_array();
      return $query;
  }
  public function first($id)
  {
      $this->db->select('
          gv_reletorio_feedback.*,
          gv_classificacoes.nome as classificacao,
          gv_orcamento_viagem.estimativa_viagem_id,

          gv_reserva.hotel_id, gv_reserva.voo_id, gv_reserva.transporte_id,
          gv_hotel.nome as hotel, gv_hotel.preco as preco_h,
          gv_transporte.nome as transporte, gv_transporte.preco as preco_t,
          gv_voo.nome as voo, gv_voo.preco as preco_v,
      ');
      $this->db->from('gv_reletorio_feedback');
      $this->db->join('gv_classificacoes', 'gv_classificacoes.id = gv_reletorio_feedback.classificacao_id', 'left');
      $this->db->join('gv_orcamento_viagem', 'gv_orcamento_viagem.id = gv_reletorio_feedback.orcamento_viagem_id', 'left');

      $this->db->join('gv_reserva', 'gv_reserva.id = gv_orcamento_viagem.reserva_id', 'left');
      $this->db->join('gv_hotel', 'gv_hotel.id = gv_reserva.hotel_id', 'left');
      $this->db->join('gv_transporte', 'gv_transporte.id = gv_reserva.transporte_id', 'left');
      $this->db->join('gv_voo', 'gv_voo.id = gv_reserva.voo_id', 'left');

      $this->db->where('gv_reletorio_feedback.id', $id);
      $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
  }
  public function create($data)
  {
    return $this->db->insert('gv_reletorio_feedback', $data);
  }
  public function delete($id)
  {
    $first = $this->first($id);

    $this->db->where('id', $id);
    $this->db->delete('gv_reletorio_feedback');

    return $first;
  }
  public function update($data, $id)
  {
    $first = $this->first($id);

    $this->db->where('id', $id);
    $this->db->update('gv_reletorio_feedback', $data);

    return $this->first($id);
  }













  // Função para pegar todos os feedbacks
  public function get_all()
  {
    // Seleciona os campos necessários
    $this->db->select('f.*');
    // $this->db->select('f.*, fu.nome as funcionario_nome, p.nome as pedido_viagem');
    // Define a tabela e os joins
    $this->db->from($this->table . ' f');
    // $this->db->join('tbl_funcionarios fu', 'fu.id = f.id_funcionario');  // Junta com a tabela de funcionários
    // $this->db->join('tbl_pedidos_viagem p', 'p.id = f.id_pedido_viagem');  // Junta com a tabela de pedidos de viagem
    $query = $this->db->get();
    return $query->result();  // Retorna todos os feedbacks encontrados
  }

  // Função para pegar um feedback pelo ID
  public function get_by_id($id)
  {
    // Seleciona os campos necessários
    $this->db->select('f.*');
    // $this->db->select('f.*, fu.nome as funcionario_nome, p.nome as pedido_viagem');
    // Define a tabela e os joins
    $this->db->from($this->table . ' f');
    // $this->db->join('tbl_funcionarios fu', 'fu.id = f.id_funcionario');  // Junta com a tabela de funcionários
    // $this->db->join('tbl_pedidos_viagem p', 'p.id = f.id_pedido_viagem');  // Junta com a tabela de pedidos de viagem
    $this->db->where('f.id', $id);  // Filtra pelo feedback com o ID fornecido
    $query = $this->db->get();
    return $query->row();  // Retorna um único feedback
  }

  // Função para inserir um novo feedback
  public function insert($data)
  {
    $this->db->insert($this->table, $data);  // Insere os dados na tabela
    return $this->db->insert_id();  // Retorna o ID do último registro inserido
  }

  // Função para excluir um feedback
  public function delete__($id)
  {
    // Verifica se o feedback com o ID fornecido existe
    $this->db->where('id', $id);
    $query = $this->db->get($this->table);

    // Se não existir, retorna 0 ou algum valor indicativo
    if ($query->num_rows() == 0) {
      return 0;  // Nenhum feedback encontrado com o ID fornecido
    }

    // Se o feedback existir, realiza a exclusão
    $this->db->where('id', $id);  // Filtra pelo feedback com o ID fornecido
    $this->db->delete($this->table);  // Exclui o feedback
    return $this->db->affected_rows();  // Retorna o número de linhas afetadas pela exclusão
  }
}