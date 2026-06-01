<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gestao_engajamento_talento_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function staffs() {
        $query = $this->db->get_where('staff', ['active' => 1]);
        return $query->result_array();
    }
    public function staffs_not_me($id) {
        $query = $this->db->get_where('staff', [
            'active' => 1,
            'staffid<>' => $id,
        ]);
        return $query->result_array();
    }
    public function colaboradores() {
        $query = $this->db->get_where('clients', ['active' => 1]);
        return $query->result_array();
    }
    public function cargos_get() {
        $query = $this->db->get('hr_job_position');
        return $query->result_array();
    }
    public function staffs_admin() {
        $query = $this->db->get_where('staff', [
            'admin' => 1,
            'active' => 1,
        ]);
        return $query->result_array();
    }
    public function get_status () {
        return $this->db->get('gets_status')->result_array();
    }

    public function get_respostas_usuario($usuario_id) {
        return $this->db->select('pergunta_engajamento_id, resposta')
        ->where('staff_id', $usuario_id)
        ->get('gets_resposta_engajamento')
        ->result_array();
    }
    private function calcular_distancia($respostas1, $respostas2) {
        $soma = 0;
        foreach ($respostas1 as $r1) {
            foreach ($respostas2 as $r2) {
                if ($r1['pergunta_engajamento_id'] == $r2['pergunta_engajamento_id']) {
                    $soma += pow($r1['resposta'] - $r2['resposta'], 2);
                }
            }
        }
        return sqrt($soma);
    }
    public function get_usuarios_similares($usuario_id) {
        // Pegamos as respostas do usuário atual
        $respostas_usuario = $this->get_respostas_usuario($usuario_id);

        // Criamos um array para armazenar os usuários similares
        $usuarios_similares = [];

        // Buscamos todos os outros usuários
        $usuarios = $this->db->distinct()->select('staff_id')
        ->where('staff_id <>', $usuario_id)->get('gets_resposta_engajamento')->result_array();

        foreach ($usuarios as $usuario) {
            $outro_usuario_id = $usuario['staff_id'];
            $respostas_outro_usuario = $this->get_respostas_usuario($outro_usuario_id);

            // Calculamos a similaridade usando distância Euclidiana
            $distancia = $this->calcular_distancia($respostas_usuario, $respostas_outro_usuario);
            // Armazenamos a similaridade
            $usuarios_similares[$outro_usuario_id] = $distancia;
        }

        // Ordenamos pelo menor valor de distância (mais similar)
        asort($usuarios_similares);
        // $usuarios_similares = array_keys(array_slice($usuarios_similares, 0, 5));
        $usuarios_similares = array_keys($usuarios_similares);
        // echo "<pre>";
        // var_dump($usuarios_similares);
        // exit;
        return $usuarios_similares; // Top 5 mais similares
    }
    public function sugerir_pesquisas($usuario_id) {
        // Obter os IDs dos usuários similares (supondo que essa função já existe)
        $usuarios_similares = $this->get_usuarios_similares($usuario_id);

        // Gerar a subquery para obter os pesquisa_id já respondidos pelo usuário atual
        // Usamos aliases para evitar ambiguidade.
        $subquery = $this->db->select('p.pesquisa_engajamento_id')
        ->from('gets_resposta_engajamento as r')
        ->join('gets_pergunta_engajamento as p', 'p.id = r.pergunta_engajamento_id', 'left')
        ->where('r.staff_id', $usuario_id)->get_compiled_select();

        // Consulta principal para obter pesquisas respondidas pelos usuários similares, mas que o usuário atual não respondeu.
        $this->db->distinct();
        $this->db->select('p.pesquisa_engajamento_id');
        $this->db->from('gets_resposta_engajamento as r');
        $this->db->join('gets_pergunta_engajamento as p', 'p.id = r.pergunta_engajamento_id', 'left');
        $this->db->where_in('r.staff_id', $usuarios_similares);
        // Aqui usamos a subquery compilada, sem escapamento, para evitar ambiguidade.
        $this->db->where("p.pesquisa_engajamento_id NOT IN ($subquery)", null, false);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function pesquisa_engajamento_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gets_pesquisa_engajamento')->num_rows();
        return $query;
    }
    public function get_pesquisa_engajamento ($status = null) {
        $this->db->select('
            gets_pesquisa_engajamento.*,
            gets_status.status,
        ');
        $this->db->from('gets_pesquisa_engajamento');
        $this->db->join('gets_status', 'gets_status.id  = gets_pesquisa_engajamento.status_id', 'left');
        if ($status) {
            $this->db->where('gets_pesquisa_engajamento.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_pesquisa_engajamento($data)
    {
        $vf_existe = $this->db->get_where('gets_pesquisa_engajamento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de pesquisa_engajamento já foi cadastrada");
            redirect('gestao_engajamento_talentos/pesquisas');
        }
        return $this->db->insert('gets_pesquisa_engajamento', $data);
    }
    public function first_pesquisa_engajamento($id) {
        $this->db->select('
            gets_pesquisa_engajamento.*,
            gets_status.status,
        ');
        $this->db->from('gets_pesquisa_engajamento');
        $this->db->join('gets_status', 'gets_status.id  = gets_pesquisa_engajamento.status_id', 'left');
        $this->db->where('gets_pesquisa_engajamento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_pesquisa_engajamento ($data, $id) {
        $this->first_pesquisa_engajamento($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gets_pesquisa_engajamento', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de pesquisa_engajamento já foi cadastrada");
                    redirect('gestao_engajamento_talentos/pesquisas');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_pesquisa_engajamento', $data);

        return $this->first_pesquisa_engajamento($id);
    }
    public function delete_pesquisa_engajamento($id) {
        $first = $this->first_pesquisa_engajamento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_pesquisa_engajamento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este pesquisa_engajamento, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/pesquisas');
        }
    }

    public function total_pergunta_engajamento()
    {
        $query = $this->db->get('gets_pergunta_engajamento')->num_rows();
        return $query;
    }
    public function get_pergunta_engajamento ($pesquisa = null) {
        $this->db->select('
            gets_pergunta_engajamento.*,
            gets_pesquisa_engajamento.titulo, gets_pesquisa_engajamento.descricao,
        ');
        $this->db->from('gets_pergunta_engajamento');
        $this->db->join('gets_pesquisa_engajamento', 'gets_pesquisa_engajamento.id  = gets_pergunta_engajamento.pesquisa_engajamento_id', 'left');
        if ($pesquisa) {
            $this->db->where('gets_pergunta_engajamento.pesquisa_engajamento_id', $pesquisa);
        }
        return $this->db->get()->result_array();
    }
    public function create_pergunta_engajamento($data)
    {
        $vf_existe = $this->db->get_where('gets_pergunta_engajamento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Pergunta de Engajamento já foi cadastrada");
            redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
        }
        return $this->db->insert('gets_pergunta_engajamento', $data);
    }
    public function first_pergunta_engajamento($id) {
        $this->db->select('
            gets_pergunta_engajamento.*,
            gets_pesquisa_engajamento.titulo, gets_pesquisa_engajamento.descricao,
        ');
        $this->db->from('gets_pergunta_engajamento');
        $this->db->join('gets_pesquisa_engajamento', 'gets_pesquisa_engajamento.id  = gets_pergunta_engajamento.pesquisa_engajamento_id', 'left');
        $this->db->where('gets_pergunta_engajamento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_pergunta_engajamento ($data, $id) {
        $this->first_pergunta_engajamento($id);
        $vf_existe = $this->db->get_where('gets_pergunta_engajamento', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Pergunta de Engajamento já foi cadastrada");
                redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_pergunta_engajamento', $data);

        return $this->first_pergunta_engajamento($id);
    }
    public function delete_pergunta_engajamento($id) {
        $first = $this->first_pergunta_engajamento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_pergunta_engajamento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Pergunta de Engajamento, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
        }
    }

    public function dashboard_resposta_engajamento ($pergunta) {
        $this->db->select('
            gets_resposta_engajamento.id,
            COUNT(id) as total_resposta,
            staff.*,
        ');
        $this->db->from('gets_resposta_engajamento');
        $this->db->join('staff', 'staff.staffid  = gets_resposta_engajamento.staff_id', 'left');
        $this->db->where('gets_resposta_engajamento.pergunta_engajamento_id', $pergunta);
        $this->db->group_by('gets_resposta_engajamento.staff_id');
        $query = $this->db->get()->result_array();

        $labels = '[';
        $total = '[';
        foreach($query as $item) {
            $labels .= '"'.$item['firstname'].' '.$item['lastname'].'",';
            $total .= '"'.$item['total_resposta'].'",';
        }
        $labels .= ']';
        $total .= ']';

        return [
            'labels' => $labels,
            'total' => $total,
        ];
    }
    public function somar_resposta_engajamento($pergunta_id = null, $resposta = null)
    {
        if ($pergunta_id != null) {
            $this->db->where('pergunta_engajamento_id', $pergunta_id);
        }
        if ($resposta != null) {
            $this->db->where('resposta', $resposta);
        }
        $this->db->select_sum('resposta');
        $query = $this->db->get('gets_resposta_engajamento');
        return $query->row()->resposta ?? 0;
    }
    public function total_resposta_engajamento($pergunta = null, $resposta = null)
    {
        if ($pergunta != null) {
            $this->db->where('pergunta_engajamento_id', $pergunta);
        }
        if ($resposta != null) {
            $this->db->where('resposta', $resposta);
        }
        $query = $this->db->get('gets_resposta_engajamento')->num_rows();
        return $query;
    }
    public function get_resposta_engajamento () {
        $this->db->select('
            gets_resposta_engajamento.*,
            staff.*,

            gets_pergunta_engajamento.texto, gets_pergunta_engajamento.tipo_resposta,
            gets_pesquisa_engajamento.titulo, gets_pesquisa_engajamento.descricao,
        ');
        $this->db->from('gets_resposta_engajamento');
        $this->db->join('staff', 'staff.staffid  = gets_resposta_engajamento.staff_id', 'left');

        $this->db->join('gets_pergunta_engajamento', 'gets_pergunta_engajamento.id  = gets_resposta_engajamento.pergunta_engajamento_id', 'left');
        $this->db->join('gets_pesquisa_engajamento', 'gets_pesquisa_engajamento.id  = gets_pergunta_engajamento.pesquisa_engajamento_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_resposta_engajamento($data)
    {
        $vf_existe = $this->db->get_where('gets_resposta_engajamento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Resposta de Engajamento já foi cadastrada");
            redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
        }
        return $this->db->insert('gets_resposta_engajamento', $data);
    }
    public function first_resposta_engajamento($id) {
        $this->db->select('
            gets_resposta_engajamento.*,
            staff.*,

            gets_pergunta_engajamento.texto, gets_pergunta_engajamento.tipo_resposta,
            gets_pesquisa_engajamento.titulo, gets_pesquisa_engajamento.descricao,
        ');
        $this->db->from('gets_resposta_engajamento');
        $this->db->join('staff', 'staff.staffid  = gets_resposta_engajamento.staff_id', 'left');

        $this->db->join('gets_pergunta_engajamento', 'gets_pergunta_engajamento.id  = gets_resposta_engajamento.pergunta_engajamento_id', 'left');
        $this->db->join('gets_pesquisa_engajamento', 'gets_pesquisa_engajamento.id  = gets_pergunta_engajamento.pesquisa_engajamento_id', 'left');
        $this->db->where('gets_resposta_engajamento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_resposta_engajamento ($data, $id) {
        $this->first_resposta_engajamento($id);
        $vf_existe = $this->db->get_where('gets_resposta_engajamento', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Resposta de Engajamento já foi cadastrada");
                redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_resposta_engajamento', $data);

        return $this->first_resposta_engajamento($id);
    }
    public function delete_resposta_engajamento($id) {
        $first = $this->first_resposta_engajamento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_resposta_engajamento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Resposta de Engajamento, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
        }
    }

    public function total_reconhecimento()
    {
        $query = $this->db->get('gets_reconhecimento')->num_rows();
        return $query;
    }
    public function get_reconhecimento () {
        $this->db->select('
            gets_reconhecimento.*,
            staff.*
        ');
        $this->db->from('gets_reconhecimento');
        $this->db->join('staff', 'staff.staffid  = gets_reconhecimento.staff_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_reconhecimento($data)
    {
        $vf_existe = $this->db->get_where('gets_reconhecimento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Reconhecimento já foi cadastrada");
            redirect('gestao_engajamento_talentos/programas');
        }
        return $this->db->insert('gets_reconhecimento', $data);
    }
    public function first_reconhecimento($id) {
        $this->db->select('
            gets_reconhecimento.*,
            staff.*
        ');
        $this->db->from('gets_reconhecimento');
        $this->db->join('staff', 'staff.staffid  = gets_reconhecimento.staff_id', 'left');
        $this->db->where('gets_reconhecimento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_reconhecimento ($data, $id) {
        $this->first_reconhecimento($id);
        $vf_existe = $this->db->get_where('gets_reconhecimento', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Reconhecimento já foi cadastrada");
                redirect('gestao_engajamento_talentos/programas');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_reconhecimento', $data);

        return $this->first_reconhecimento($id);
    }
    public function delete_reconhecimento($id) {
        $first = $this->first_reconhecimento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_reconhecimento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Reconhecimento, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/programas');
        }
    }

    public function total_premio()
    {
        $query = $this->db->get('gets_premio')->num_rows();
        return $query;
    }
    public function get_premio () {
        $this->db->select('
            gets_premio.*,
        ');
        $this->db->from('gets_premio');
        return $this->db->get()->result_array();
    }
    public function create_premio($data)
    {
        $vf_existe = $this->db->get_where('gets_premio', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Premio já foi cadastrada");
            redirect('gestao_engajamento_talentos/programas_premio');
        }
        return $this->db->insert('gets_premio', $data);
    }
    public function first_premio($id) {
        $this->db->select('
            gets_premio.*,
        ');
        $this->db->from('gets_premio');
        $this->db->where('gets_premio.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_premio ($data, $id) {
        $this->first_premio($id);
        $vf_existe = $this->db->get_where('gets_premio', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Premio já foi cadastrada");
                redirect('gestao_engajamento_talentos/programas_premio');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_premio', $data);

        return $this->first_premio($id);
    }
    public function delete_premio($id) {
        $first = $this->first_premio($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_premio');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Premio, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/programas_premio');
        }
    }

    public function total_resgate_premio()
    {
        $query = $this->db->get('gets_resgate_premio')->num_rows();
        return $query;
    }
    public function get_resgate_premio () {
        $this->db->select('
            gets_resgate_premio.*,
            staff.*,
            gets_premio.nome as p_nome, gets_premio.descricao as p_descricao, gets_premio.pontos_necessario,
        ');
        $this->db->from('gets_resgate_premio');
        $this->db->join('staff', 'staff.staffid  = gets_resgate_premio.staff_id', 'left');
        $this->db->join('gets_premio', 'gets_premio.id  = gets_resgate_premio.premio_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_resgate_premio($data)
    {
        $vf_existe = $this->db->get_where('gets_resgate_premio', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Resgate de Prêmio já foi cadastrada");
            redirect('gestao_engajamento_talentos/programas_resgate');
        }
        return $this->db->insert('gets_resgate_premio', $data);
    }
    public function first_resgate_premio($id) {
        $this->db->select('
            gets_resgate_premio.*,
            staff.*,
            gets_premio.nome as p_nome, gets_premio.descricao as p_descricao, gets_premio.pontos_necessario,
        ');
        $this->db->from('gets_resgate_premio');
        $this->db->join('staff', 'staff.staffid  = gets_resgate_premio.staff_id', 'left');
        $this->db->join('gets_premio', 'gets_premio.id  = gets_resgate_premio.premio_id', 'left');
        $this->db->where('gets_resgate_premio.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_resgate_premio ($data, $id) {
        $this->first_resgate_premio($id);
        $vf_existe = $this->db->get_where('gets_resgate_premio', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Resgate de Prêmio já foi cadastrada");
                redirect('gestao_engajamento_talentos/programas_resgate');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_resgate_premio', $data);

        return $this->first_resgate_premio($id);
    }
    public function delete_resgate_premio($id) {
        $first = $this->first_resgate_premio($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_resgate_premio');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Resgate de Prêmio, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/programas_resgate');
        }
    }

    public function total_comunicacao_interna()
    {
        $query = $this->db->get('gets_comunicacao_interna')->num_rows();
        return $query;
    }
    public function get_comunicacao_interna () {
        $this->db->select('
            gets_comunicacao_interna.*,
            staff.*
        ');
        $this->db->from('gets_comunicacao_interna');
        $this->db->join('staff', 'staff.staffid  = gets_comunicacao_interna.autor_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_comunicacao_interna($data)
    {
        $vf_existe = $this->db->get_where('gets_comunicacao_interna', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Comunicação já foi cadastrada");
            redirect('gestao_engajamento_talentos/comunicacao');
        }
        return $this->db->insert('gets_comunicacao_interna', $data);
    }
    public function first_comunicacao_interna($id) {
        $this->db->select('
            gets_comunicacao_interna.*,
            staff.*
        ');
        $this->db->from('gets_comunicacao_interna');
        $this->db->join('staff', 'staff.staffid  = gets_comunicacao_interna.autor_id', 'left');
        $this->db->where('gets_comunicacao_interna.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_comunicacao_interna ($data, $id) {
        $this->first_comunicacao_interna($id);
        $vf_existe = $this->db->get_where('gets_comunicacao_interna', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Comunicação já foi cadastrada");
                redirect('gestao_engajamento_talentos/comunicacao');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_comunicacao_interna', $data);

        return $this->first_comunicacao_interna($id);
    }
    public function delete_comunicacao_interna($id) {
        $first = $this->first_comunicacao_interna($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_comunicacao_interna');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Comunicação, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/comunicacao');
        }
    }

    // Feedback Continuo
    public function total_feedback_continuo()
    {
        $query = $this->db->get('gets_feedback_continuo')->num_rows();
        return $query;
    }
    public function get_feedback_continuo ($idLogado = null) {
        $this->db->select('
            gets_feedback_continuo.*,
            remetente.firstname as r_firstname, remetente.lastname as r_lastname,
            destinatario.firstname as d_firstname, destinatario.lastname as d_lastname,
        ');
        $this->db->from('gets_feedback_continuo');
        $this->db->join('staff as remetente', 'remetente.staffid  = gets_feedback_continuo.remetente_id', 'left');
        $this->db->join('staff as destinatario', 'destinatario.staffid  = gets_feedback_continuo.destinatario_id', 'left');
        if ($idLogado) {
            $this->db->where('gets_feedback_continuo.remetente_id', $idLogado);
            $this->db->or_where('gets_feedback_continuo.destinatario_id', $idLogado);
        }
        return $this->db->get()->result_array();
    }
    public function create_feedback_continuo($data)
    {
        return $this->db->insert('gets_feedback_continuo', $data);
    }
    public function first_feedback_continuo($id, $idLogado = null) {
        $this->db->select('
            gets_feedback_continuo.*,
            remetente.firstname as r_firstname, remetente.lastname as r_lastname,
            destinatario.firstname as d_firstname, destinatario.lastname as d_lastname,
        ');
        $this->db->from('gets_feedback_continuo');
        $this->db->join('staff as remetente', 'remetente.staffid  = gets_feedback_continuo.remetente_id', 'left');
        $this->db->join('staff as destinatario', 'destinatario.staffid  = gets_feedback_continuo.destinatario_id', 'left');
        $this->db->where('gets_feedback_continuo.id', $id);
        if ($idLogado) {
            $this->db->where('gets_feedback_continuo.remetente_id', $idLogado);
            $this->db->or_where('gets_feedback_continuo.destinatario_id', $idLogado);
        }
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function delete_feedback_continuo($id) {
        $first = $this->first_feedback_continuo($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_feedback_continuo');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Resposta de Clima, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/feedback');
        }
    }

    // GrupoColaboracao
    public function total_grupo_colaboracao()
    {
        $query = $this->db->get('gets_grupo_colaboracao')->num_rows();
        return $query;
    }
    public function get_grupo_colaboracao () {
        $this->db->select('
            gets_grupo_colaboracao.*,
            staff.*
        ');
        $this->db->from('gets_grupo_colaboracao');
        $this->db->join('staff', 'staff.staffid  = gets_grupo_colaboracao.criador_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_grupo_colaboracao($data)
    {
        $vf_existe = $this->db->get_where('gets_grupo_colaboracao', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Grupo de Colaboração já foi cadastrada");
            redirect('gestao_engajamento_talentos/comunidade');
        }
        return $this->db->insert('gets_grupo_colaboracao', $data);
    }
    public function first_grupo_colaboracao($id) {
        $this->db->select('
            gets_grupo_colaboracao.*,
            staff.*
        ');
        $this->db->from('gets_grupo_colaboracao');
        $this->db->join('staff', 'staff.staffid  = gets_grupo_colaboracao.criador_id', 'left');
        $this->db->where('gets_grupo_colaboracao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_grupo_colaboracao ($data, $id) {
        $this->first_grupo_colaboracao($id);
        $vf_existe = $this->db->get_where('gets_grupo_colaboracao', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Grupo de Colaboração já foi cadastrada");
                redirect('gestao_engajamento_talentos/comunidade');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_grupo_colaboracao', $data);

        return $this->first_grupo_colaboracao($id);
    }
    public function delete_grupo_colaboracao($id) {
        $first = $this->first_grupo_colaboracao($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_grupo_colaboracao');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Grupo de Colaboração, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/comunidade');
        }
    }

    // Evento
    public function total_evento()
    {
        $query = $this->db->get('gets_evento')->num_rows();
        return $query;
    }
    public function get_evento () {
        $this->db->select('
            gets_evento.*,
            staff.*
        ');
        $this->db->from('gets_evento');
        $this->db->join('staff', 'staff.staffid  = gets_evento.organizador_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_evento($data)
    {
        $vf_existe = $this->db->get_where('gets_evento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Evento já foi cadastrada");
            redirect('gestao_engajamento_talentos/comunidade_evento');
        }
        return $this->db->insert('gets_evento', $data);
    }
    public function first_evento($id) {
        $this->db->select('
            gets_evento.*,
            staff.*
        ');
        $this->db->from('gets_evento');
        $this->db->join('staff', 'staff.staffid  = gets_evento.organizador_id', 'left');
        $this->db->where('gets_evento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_evento ($data, $id) {
        $this->first_evento($id);
        $vf_existe = $this->db->get_where('gets_evento', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Evento já foi cadastrada");
                redirect('gestao_engajamento_talentos/comunidade_evento');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_evento', $data);

        return $this->first_evento($id);
    }
    public function delete_evento($id) {
        $first = $this->first_evento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_evento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Evento, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/comunidade_evento');
        }
    }

    public function total_pesquisa_clima($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gets_pesquisa_clima')->num_rows();
        return $query;
    }
    public function get_pesquisa_clima ($status = null) {
        $this->db->select('
            gets_pesquisa_clima.*,
            gets_status.status,
        ');
        $this->db->from('gets_pesquisa_clima');
        $this->db->join('gets_status', 'gets_status.id  = gets_pesquisa_clima.status_id', 'left');
        if ($status) {
            $this->db->where('gets_pesquisa_clima.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_pesquisa_clima($data)
    {
        $vf_existe = $this->db->get_where('gets_pesquisa_clima', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Pesquisa de Clima já foi cadastrada");
            redirect('gestao_engajamento_talentos/clima');
        }
        return $this->db->insert('gets_pesquisa_clima', $data);
    }
    public function first_pesquisa_clima($id) {
        $this->db->select('
            gets_pesquisa_clima.*,
            gets_status.status,
        ');
        $this->db->from('gets_pesquisa_clima');
        $this->db->join('gets_status', 'gets_status.id  = gets_pesquisa_clima.status_id', 'left');
        $this->db->where('gets_pesquisa_clima.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_pesquisa_clima ($data, $id) {
        $this->first_pesquisa_clima($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gets_pesquisa_clima', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Pesquisa de Clima já foi cadastrada");
                    redirect('gestao_engajamento_talentos/clima');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_pesquisa_clima', $data);

        return $this->first_pesquisa_clima($id);
    }
    public function delete_pesquisa_clima($id) {
        $first = $this->first_pesquisa_clima($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_pesquisa_clima');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Pesquisa de Clima, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/clima');
        }
    }

    public function total_pergunta_clima()
    {
        $query = $this->db->get('gets_pergunta_clima')->num_rows();
        return $query;
    }
    public function get_pergunta_clima ($pesquisa = null) {
        $this->db->select('
            gets_pergunta_clima.*,
            gets_pesquisa_clima.titulo, gets_pesquisa_clima.descricao,
        ');
        $this->db->from('gets_pergunta_clima');
        $this->db->join('gets_pesquisa_clima', 'gets_pesquisa_clima.id  = gets_pergunta_clima.pesquisa_clima_id', 'left');
        if ($pesquisa) {
            $this->db->where('gets_pergunta_clima.pesquisa_clima_id', $pesquisa);
        }
        return $this->db->get()->result_array();
    }
    public function create_pergunta_clima($data)
    {
        $vf_existe = $this->db->get_where('gets_pergunta_clima', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Pergunta de Clima já foi cadastrada");
            redirect('gestao_engajamento_talentos/clima_pergunta_clima');
        }
        return $this->db->insert('gets_pergunta_clima', $data);
    }
    public function first_pergunta_clima($id) {
        $this->db->select('
            gets_pergunta_clima.*,
            gets_pesquisa_clima.titulo, gets_pesquisa_clima.descricao,
        ');
        $this->db->from('gets_pergunta_clima');
        $this->db->join('gets_pesquisa_clima', 'gets_pesquisa_clima.id  = gets_pergunta_clima.pesquisa_clima_id', 'left');
        $this->db->where('gets_pergunta_clima.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_pergunta_clima ($data, $id) {
        $this->first_pergunta_clima($id);
        $vf_existe = $this->db->get_where('gets_pergunta_clima', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Pergunta de Clima já foi cadastrada");
                redirect('gestao_engajamento_talentos/clima_pergunta_clima');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_pergunta_clima', $data);

        return $this->first_pergunta_clima($id);
    }
    public function delete_pergunta_clima($id) {
        $first = $this->first_pergunta_clima($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_pergunta_clima');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Pergunta de Clima, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/clima_pergunta_clima');
        }
    }

    public function total_resposta_clima()
    {
        $query = $this->db->get('gets_resposta_clima')->num_rows();
        return $query;
    }
    public function get_resposta_clima () {
        $this->db->select('
            gets_resposta_clima.*,
            staff.*,

            gets_pergunta_clima.texto, gets_pergunta_clima.tipo_resposta,
            gets_pesquisa_clima.titulo, gets_pesquisa_clima.descricao,
        ');
        $this->db->from('gets_resposta_clima');
        $this->db->join('staff', 'staff.staffid  = gets_resposta_clima.staff_id', 'left');

        $this->db->join('gets_pergunta_clima', 'gets_pergunta_clima.id  = gets_resposta_clima.pergunta_clima_id', 'left');
        $this->db->join('gets_pesquisa_clima', 'gets_pesquisa_clima.id  = gets_pergunta_clima.pesquisa_clima_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_resposta_clima($data)
    {
        $vf_existe = $this->db->get_where('gets_resposta_clima', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Resposta de Clima já foi cadastrada");
            redirect('gestao_engajamento_talentos/clima_resposta_clima');
        }
        return $this->db->insert('gets_resposta_clima', $data);
    }
    public function first_resposta_clima($id) {
        $this->db->select('
            gets_resposta_clima.*,
            staff.*,

            gets_pergunta_clima.texto, gets_pergunta_clima.tipo_resposta,
            gets_pesquisa_clima.titulo, gets_pesquisa_clima.descricao,
        ');
        $this->db->from('gets_resposta_clima');
        $this->db->join('staff', 'staff.staffid  = gets_resposta_clima.staff_id', 'left');

        $this->db->join('gets_pergunta_clima', 'gets_pergunta_clima.id  = gets_resposta_clima.pergunta_clima_id', 'left');
        $this->db->join('gets_pesquisa_clima', 'gets_pesquisa_clima.id  = gets_pergunta_clima.pesquisa_clima_id', 'left');
        $this->db->where('gets_resposta_clima.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_resposta_clima ($data, $id) {
        $this->first_resposta_clima($id);
        $vf_existe = $this->db->get_where('gets_resposta_clima', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Resposta de Clima já foi cadastrada");
                redirect('gestao_engajamento_talentos/clima_resposta_clima');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_resposta_clima', $data);

        return $this->first_resposta_clima($id);
    }
    public function delete_resposta_clima($id) {
        $first = $this->first_resposta_clima($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_resposta_clima');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Resposta de Clima, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/clima_resposta_clima');
        }
    }


    public function get_conflito_dashboard ($status = null) {
        $this->db->select('
            gets_conflito.*,
            staff.staffid, staff.firstname, staff.lastname
        ');
        $this->db->from('gets_conflito');
        $this->db->join('staff', 'staff.staffid  = gets_conflito.staff_id', 'left');
        if ($status) {
            $this->db->where('gets_conflito.status', $status);
        }
        $this->db->limit(4);
        $query = $this->db->get()->result_array();
        $dados = "";
        $i = 0;
        foreach ($query as $item) {
            $i++;
            $total = $this->medicao_conflito_total(null, $item['id']);
            $dados .= "[".$i.",".$total.",'".$item['descricao']."'],";
        }
        return $dados;
    }
    public function conflito_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status', $status);
        }
        $query = $this->db->get('gets_conflito')->num_rows();
        return $query;
    }
    public function get_conflito ($status = null) {
        $this->db->select('
            gets_conflito.*,
            staff.staffid, staff.firstname, staff.lastname
        ');
        $this->db->from('gets_conflito');
        $this->db->join('staff', 'staff.staffid  = gets_conflito.staff_id', 'left');
        if ($status) {
            $this->db->where('gets_conflito.status', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_conflito($data)
    {
        $vf_existe = $this->db->get_where('gets_conflito', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Conflito já foi cadastrada");
            redirect('gestao_engajamento_talentos/conflitos');
        }
        return $this->db->insert('gets_conflito', $data);
    }
    public function first_conflito($id) {
        $this->db->select('
            gets_conflito.*,
            staff.staffid, staff.firstname, staff.lastname
        ');
        $this->db->from('gets_conflito');
        $this->db->join('staff', 'staff.staffid  = gets_conflito.staff_id', 'left');
        $this->db->where('gets_conflito.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_conflito ($data, $id) {
        $this->first_conflito($id);
        $vf_existe = $this->db->get_where('gets_conflito', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"conflito já foi cadastrada");
                redirect('gestao_engajamento_talentos/conflitos');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_conflito', $data);

        return $this->first_conflito($id);
    }
    public function delete_conflito($id) {
        $first = $this->first_conflito($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_conflito');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Conflito, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/conflitos');
        }
    }

    public function medicao_conflito_total($status = null, $conflito = null)
    {
        if ($status != null) {
            $this->db->where('status', $status);
        }
        if ($conflito != null) {
            $this->db->where('conflito_id', $conflito);
        }
        $query = $this->db->get('gets_medicao_conflito')->num_rows();
        return $query;
    }
    public function get_medicao_conflito ($status = null) {
        $this->db->select('
            gets_medicao_conflito.*,
            staff.staffid, staff.firstname, staff.lastname,
            gets_conflito.descricao c_descricao, gets_conflito.data_registro, gets_conflito.status c_status
        ');
        $this->db->from('gets_medicao_conflito');
        $this->db->join('staff', 'staff.staffid  = gets_medicao_conflito.mediador_id', 'left');
        $this->db->join('gets_conflito', 'gets_conflito.id  = gets_medicao_conflito.conflito_id', 'left');
        if ($status) {
            $this->db->where('gets_medicao_conflito.status', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_medicao_conflito($data)
    {
        $vf_existe = $this->db->get_where('gets_medicao_conflito', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Medição Conflito já foi cadastrada");
            redirect('gestao_engajamento_talentos/conflitos_mediacao');
        }
        return $this->db->insert('gets_medicao_conflito', $data);
    }
    public function first_medicao_conflito($id) {
        $this->db->select('
            gets_medicao_conflito.*,
            staff.staffid, staff.firstname, staff.lastname,
            gets_conflito.descricao c_descricao, gets_conflito.data_registro, gets_conflito.status c_status
        ');
        $this->db->from('gets_medicao_conflito');
        $this->db->join('staff', 'staff.staffid  = gets_medicao_conflito.mediador_id', 'left');
        $this->db->join('gets_conflito', 'gets_conflito.id  = gets_medicao_conflito.conflito_id', 'left');
        $this->db->where('gets_medicao_conflito.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_medicao_conflito ($data, $id) {
        $this->first_medicao_conflito($id);
        $vf_existe = $this->db->get_where('gets_medicao_conflito', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Medição Conflito já foi cadastrada");
                redirect('gestao_engajamento_talentos/conflitos_mediacao');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gets_medicao_conflito', $data);

        return $this->first_medicao_conflito($id);
    }
    public function delete_medicao_conflito($id) {
        $first = $this->first_medicao_conflito($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gets_medicao_conflito');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Medição Conflito, esta associada a outras entidades.");
            redirect('gestao_engajamento_talentos/conflitos_mediacao');
        }
    }
}
?>