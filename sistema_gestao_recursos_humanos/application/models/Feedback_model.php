<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback_model extends CI_Model
{
  // Nome da tabela
  private $table = 'tblgv_feedback';

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

  // Função para atualizar um feedback
  public function update($id, $data)
  {
    $this->db->where('id', $id);  // Filtra pelo feedback com o ID fornecido
    $this->db->update($this->table, $data);  // Atualiza o feedback com os novos dados
    return $this->db->affected_rows();  // Retorna o número de linhas afetadas pela atualização
  }

  // Função para excluir um feedback
  public function delete($id)
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
