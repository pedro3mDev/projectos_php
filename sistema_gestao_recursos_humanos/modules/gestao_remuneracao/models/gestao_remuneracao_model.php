<?php

defined('BASEPATH') or exit('No direct script access allowed');

class gestao_remuneracao_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function staffs()
    {
        $query = $this->db->get_where('staff', ['active' => 1]);
        return $query->result_array();
    }
    public function cargos_get()
    {
        $query = $this->db->get('hr_job_position');
        return $query->result_array();
    }
    public function staffs_admin()
    {
        $query = $this->db->get_where('staff', [
            'admin' => 1,
            'active' => 1,
        ]);
        return $query->result_array();
    }

    /* public function get_desempenho () {
        return $this->db->get('psl_desempenho')->result_array();
    } */
    /* public function get_potencial () {
        return $this->db->get('psl_potencial')->result_array();
    } */
    /* public function get_nivel_critico () {
        return $this->db->get('psl_nivel_critico')->result_array();
    } */
    public function get_status()
    {
        return $this->db->get('gr_status')->result_array();
    }

    #============================ Ciclo Revisao Salarial ===========================================
    public function create_ciclo_revisao_salarial($data)
    {
        return $this->db->insert('gr_ciclo_revisao_salarial', $data);
    }
    public function get_ciclo_revisao_salarial()
    {
        return $this->db->get('gr_ciclo_revisao_salarial')->result_array();
    }
    public function get_ciclo_revisao_salarial_filter($id)
    {
        //return $this->db->get('gr_ciclo_revisao_salarial')->result_array();
        return $this->db->get_where('gr_ciclo_revisao_salarial', ['id' => $id])->row_array();
    }
    #=============================== Departamento ===========================
    public function get_departamento()
    {
        return $this->db->get('departments')->result_array();
    }
    #========================================================================================

    #================================ Ajuste Salarial =======================================
    public function create_ajuste_Salarial($data)
    {
        return $this->db->insert('gr_ajuste_salarial', $data);
    }
    public function verificar_relacionamento_ajuste_salarial($id)
    {

        $this->db->where("mentoria_id", $id);
        $query = $this->db->get("gdi_plano_desenvolvimento");

        return $query->row() !== null;
    }
    public function get_ajuste_salarial()
    {
        $this->db->select('
        gr_ajuste_salarial.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome,
    ');
        $this->db->from('gr_ajuste_salarial');
        $this->db->join('gr_status', 'gr_status.id = gr_ajuste_salarial.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_ajuste_salarial.staff_id', 'left');

        $valores = $this->db->get()->result_array();

        foreach ($valores as &$valore) {
            $aprovadores_ids = json_decode($valore['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $valore['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $valore['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($valore);

        return $valores;
    }

    public function get_ajuste_salarial_filter($id)
    {
        $this->db->select('
            gr_ajuste_salarial.*,
            gr_status.status AS status_nome,
            gr_status.id AS status_id,
            staff.firstname as primeiro_nome,
            staff.lastname as segundo_nome
        ');
        $this->db->from('gr_ajuste_salarial');
        $this->db->join('gr_status', 'gr_status.id = gr_ajuste_salarial.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_ajuste_salarial.staff_id', 'left');
        $this->db->where('gr_ajuste_salarial.id', $id);
        $valores = $this->db->get()->row_array();
    
        // Verifica se encontrou algum resultado
        if (!$valores) {
            return null; // Retorna null para evitar erro ao tentar acessar uma chave inexistente
        }
    
        // Decodifica a lista de aprovadores
        $aprovadores_ids = !empty($valores['aprovadores']) ? json_decode($valores['aprovadores'], true) : [];
    
        // Garante que 'aprovadores_nomes' exista no array
        $valores['aprovadores_nomes'] = "Nenhum";
    
        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);
            $result = $this->db->get()->result_array();
    
            if (!empty($result)) {
                $valores['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            }
        }
    
        return $valores;
    }
    

    public function first_ajuste_salarial($id)
    {
        $this->db->select('
        gr_ajuste_salarial.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
    ');
        $this->db->from('gr_ajuste_salarial');
        $this->db->join('gr_status', 'gr_status.id = gr_ajuste_salarial.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_ajuste_salarial.staff_id', 'left');
        $this->db->where('gr_ajuste_salarial.id', $id);

        $valorer = $this->db->get()->row_array();
        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }

        return $valorer;
    }

    public function ajuste_salarial_update($data, $id)
    {
        $this->first_ajuste_salarial($id);
        $this->db->where('id', $id);
        $this->db->update('gr_ajuste_salarial', $data);
        return $this->first_ajuste_salarial($id);
    }



    public function get_filtered_ajuste_salaria($funcionario = null, $status = null)
    {
        $this->db->select('
        gdi_mentoria.*,
        gdi_status.status AS status_nome,
        gdi_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
        ');
        $this->db->from('gdi_mentoria');
        $this->db->join('gdi_status', 'gdi_status.id = gdi_mentoria.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gdi_mentoria.staff_id', 'left');

        // Filtrar por funcionário
        if (!empty($funcionario)) {
            $this->db->where('gdi_mentoria.staff_id', $funcionario);
        }

        // Filtrar por status
        if (!empty($status)) {
            $this->db->where('gdi_mentoria.status_id', $status);
        }

        $valores = $this->db->get()->result_array();

        foreach ($valores as &$valor) {
            $aprovadores_ids = json_decode($valor['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $valor['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $valor['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($valor);

        return $valores;
    }

    #==========================Relatorio Corporativo ======================================
    public function create_relatorio_comparativo($data)
    {
        return $this->db->insert('gr_relatorio_comparativo', $data);
    }
    public function get_relatorio_comparativo()
    {
        return $this->db->get('gr_relatorio_comparativo')->result_array();
    }
    public function get_comparativo_relatorio_filter($id){
        return $this->db->get_where('gr_relatorio_comparativo', ['id' => $id])->row_array();
    }
    #=================================Pacote Benefiico========================================

    public function create_pacote_beneficio($data)
    {
        return $this->db->insert('gr_pacote_beneficio', $data);
    }
    public function get_pacote_beneficio()
    {
        $this->db->select('
        gr_pacote_beneficio.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
    ');
        $this->db->from('gr_pacote_beneficio');
        $this->db->join('gr_status', 'gr_status.id = gr_pacote_beneficio.status_id', 'left');

        $pacote_beneficio = $this->db->get()->result_array();

        foreach ($pacote_beneficio as &$pacote_beneficios) {
            $aprovadores_ids = json_decode($pacote_beneficios['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $pacote_beneficios['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $pacote_beneficios['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($pacote_beneficios);

        return $pacote_beneficio;
    }

    public function get_pacote($id)
    {
        $this->db->select('
        gr_pacote_beneficio.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
    ');
        $this->db->from('gr_pacote_beneficio');
        $this->db->join('gr_status', 'gr_status.id = gr_pacote_beneficio.status_id', 'left');
        $this->db->where('gr_pacote_beneficio.id', $id);
        $valorer = $this->db->get()->row_array();

        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }

        return $valorer;
    }

    public function first_pacote_beneficio($id)
    {
        $this->db->select('
        gr_pacote_beneficio.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
    ');
        $this->db->from('gr_pacote_beneficio');
        $this->db->join('gr_status', 'gr_status.id = gr_pacote_beneficio.status_id', 'left');
        $this->db->where('gr_pacote_beneficio.id', $id);

        $valorer = $this->db->get()->row_array();
        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }

        return $valorer;
    }
    public function pacote_beneficio_update($data, $id)
    {
        $this->first_pacote_beneficio($id);
        $this->db->where('id', $id);
        $this->db->update('gr_pacote_beneficio', $data);
        return $this->first_pacote_beneficio($id);
    }

    #=======================Beneficio Funcionaio======================
    public function get_beneficio_funcionario()
    {
        $this->db->select('
        gr_beneficio_funcionario.*,
        gr_pacote_beneficio.elegibilidade,  
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
    ');
        $this->db->from('gr_beneficio_funcionario');
        $this->db->join('gr_pacote_beneficio', 'gr_pacote_beneficio.id = gr_beneficio_funcionario.beneficio_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_beneficio_funcionario.staff_id', 'left');
        return $this->db->get()->result_array();
    }

    public function get_beneficio_funcionario_filter($id)
    {
        $this->db->select('
        gr_beneficio_funcionario.*,
        gr_pacote_beneficio.elegibilidade,  
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
    ');
        $this->db->from('gr_beneficio_funcionario');
        $this->db->join('gr_pacote_beneficio', 'gr_pacote_beneficio.id = gr_beneficio_funcionario.beneficio_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_beneficio_funcionario.staff_id', 'left');
        $this->db->where('gr_beneficio_funcionario.id',$id);
        return $this->db->get()->row_array();
    }
    public function create_beneficio_funcionario($data)
    {
        return $this->db->insert('gr_beneficio_funcionario', $data);
    }

    #=======================Alterar Beneficio======================
    public function get_alterar_beneficio()
    {
        $this->db->select('
        gr_alterar_beneficio.*,
        gr_pacote_beneficio.elegibilidade,  
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
        ');
        $this->db->from('gr_alterar_beneficio');
        $this->db->join('gr_pacote_beneficio', 'gr_pacote_beneficio.id = gr_alterar_beneficio.beneficio_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_alterar_beneficio.staff_id', 'left');
        return $this->db->get()->result_array();
    }

    public function get_alterar_beneficio_filter($id)
    {
        $this->db->select('
        gr_alterar_beneficio.*,
        gr_pacote_beneficio.elegibilidade,  
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
        ');
        $this->db->from('gr_alterar_beneficio');
        $this->db->join('gr_pacote_beneficio', 'gr_pacote_beneficio.id = gr_alterar_beneficio.beneficio_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_alterar_beneficio.staff_id', 'left');
        $this->db->where('gr_alterar_beneficio.id',$id);
        return $this->db->get()->row_array();
    }
    public function create_alterar_beneficio($data)
    {
        return $this->db->insert('gr_alterar_beneficio', $data);
    }

    #=================================Solicitação Benefiico========================================

    public function create_solicitacao_beneficio($data)
    {
        return $this->db->insert('gr_solicitacao_beneficio', $data);
    }
    public function get_solicitacao_beneficio()
    {
        $this->db->select('
        gr_solicitacao_beneficio.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome,
        gr_pacote_beneficio.elegibilidade,  
    ');
        $this->db->from('gr_solicitacao_beneficio');
        $this->db->join('gr_status', 'gr_status.id = gr_solicitacao_beneficio.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_solicitacao_beneficio.staff_id', 'left');
        $this->db->join('gr_pacote_beneficio', 'gr_pacote_beneficio.id = gr_solicitacao_beneficio.beneficio_id', 'left');


        $pacote_beneficio = $this->db->get()->result_array();

        foreach ($pacote_beneficio as &$pacote_beneficios) {
            $aprovadores_ids = json_decode($pacote_beneficios['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $pacote_beneficios['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $pacote_beneficios['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($pacote_beneficios);

        return $pacote_beneficio;
    }

    public function get_solicitacao_beneficio_filter($id)
    {
        $this->db->select('
        gr_solicitacao_beneficio.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome,
        gr_pacote_beneficio.elegibilidade,  
    ');
        $this->db->from('gr_solicitacao_beneficio');
        $this->db->join('gr_status', 'gr_status.id = gr_solicitacao_beneficio.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_solicitacao_beneficio.staff_id', 'left');
        $this->db->join('gr_pacote_beneficio', 'gr_pacote_beneficio.id = gr_solicitacao_beneficio.beneficio_id', 'left');
        $this->db->where('gr_solicitacao_beneficio.id', $id);

        $valorer = $this->db->get()->row_array();
        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }

        return $valorer;
    }

    public function first_solicitacao_beneficio($id)
    {
        $this->db->select('
        gr_solicitacao_beneficio.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
    ');
        $this->db->from('gr_solicitacao_beneficio');
        $this->db->join('gr_status', 'gr_status.id = gr_solicitacao_beneficio.status_id', 'left');
        $this->db->where('gr_solicitacao_beneficio.id', $id);

        $valorer = $this->db->get()->row_array();
        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }

        return $valorer;
    }
    public function solicitacao_beneficio_update($data, $id)
    {
        $this->first_solicitacao_beneficio($id);
        $this->db->where('id', $id);
        $this->db->update('gr_solicitacao_beneficio', $data);
        return $this->first_solicitacao_beneficio($id);
    }
    #===============================Tipo Categoria ===================================
    public function get_tipo_categoria()
    {
        return $this->db->get('gr_tipo_categoria')->result_array();
    }
    public function create_tipo_categoria($data)
    {
        $vf_existe = $this->db->get_where('gr_tipo_categoria', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "Tipo Categoria já foi cadastrada");
            redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
        }
        return $this->db->insert('gr_tipo_categoria', $data);
    }
    public function first_tipo_categoria($id)
    {
        $query = $this->db->get_where('gr_tipo_categoria', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_tipo_categoria($data, $id)
    {
        $this->first_tipo_categoria($id);
        $vf_existe = $this->db->get_where('gr_tipo_categoria', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Tipo Categoria já foi cadastrada");
                redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gr_tipo_categoria', $data);

        return $this->first_tipo_categoria($id);
    }
    public function delete_tipo_categoria($id)
    {
        $first = $this->first_tipo_categoria($id);
        $this->db->where('id', $id);
        $this->db->delete('gr_tipo_categoria');
        return $first;
    }
    public function verificar_relacionamento_tipo_categoria($id)
    {
        $this->db->where("tipo_avaliacao_id", $id);
        $query = $this->db->get("gdi_avaliacao");

        return $query->row() !== null;
    }

    #==========================Benchmark Salarial ======================================
    public function create_benchmark_salarial($data)
    {
        return $this->db->insert('gr_benchmark_salarial', $data);
    }
    public function get_benchmark_salarial()
    {
        return $this->db->get('gr_benchmark_salarial')->result_array();
    }
    public function get_benchmark_salarial_filter($id)
    {
        return $this->db->get_where('gr_benchmark_salarial', ['id' => $id])->row_array();
      
    }
    #==========================Faixa Salarial ======================================
    public function create_faixa_salarial($data)
    {
        return $this->db->insert('gr_faixa_salarial', $data);
    }
    public function get_faixa_salarial_filter($id)
    {
        // return $this->db->get_where('gr_faixa_salarial', ['id' => $id])->row_array();
        $this->db->select('
        gr_faixa_salarial.*,
        gr_tipo_categoria.nome AS categoria_nome,
        hr_job_position.position_name,'
        );
        $this->db->from('gr_faixa_salarial');
        $this->db->join('gr_tipo_categoria', 'gr_tipo_categoria.id = gr_faixa_salarial.tipo_categoria_id', 'left');
        $this->db->join('hr_job_position', 'hr_job_position.position_id = gr_faixa_salarial.cargo_id', 'left');
        $this->db->where('gr_faixa_salarial.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_faixa_salarial()
    {
        $this->db->select('
        gr_faixa_salarial.*,
        gr_tipo_categoria.nome AS categoria_nome,
        hr_job_position.position_name,
    ');
        $this->db->from('gr_faixa_salarial');
        $this->db->join('gr_tipo_categoria', 'gr_tipo_categoria.id = gr_faixa_salarial.tipo_categoria_id', 'left');
        $this->db->join('hr_job_position', 'hr_job_position.position_id = gr_faixa_salarial.cargo_id', 'left');

        //$pacote_beneficio = $this->db->get()->result_array();
        return $this->db->get()->result_array();
    }

    #==========================Comparação Salarial ======================================
    public function create_comparacao_salarial($data)
    {
        return $this->db->insert('gr_comparacao_salarial', $data);
    }
    public function get_comparacao_salarial()
    {
        $this->db->select('
       gr_comparacao_salarial.*,
       gr_benchmark_salarial.setor,
       gr_faixa_salarial.salario_min,
       gr_faixa_salarial.salario_max,
   ');
        $this->db->from('gr_comparacao_salarial');
        $this->db->join('gr_benchmark_salarial', 'gr_benchmark_salarial.id = gr_comparacao_salarial.benchmark_salarial_id', 'left');
        $this->db->join('gr_faixa_salarial', 'gr_faixa_salarial.id = gr_comparacao_salarial.faixa_salarial_id', 'left');

        return $this->db->get()->result_array();
    }
    public function get_comparacao_salarial_filter($id)
    {
        $this->db->select('
        gr_comparacao_salarial.*,
        gr_benchmark_salarial.setor,
        gr_faixa_salarial.salario_min,
        gr_faixa_salarial.salario_max,
       ');

        $this->db->from('gr_comparacao_salarial');
        $this->db->join('gr_benchmark_salarial', 'gr_benchmark_salarial.id = gr_comparacao_salarial.benchmark_salarial_id', 'left');
        $this->db->join('gr_faixa_salarial', 'gr_faixa_salarial.id = gr_comparacao_salarial.faixa_salarial_id', 'left');
        $this->db->where('gr_comparacao_salarial.id',$id);
        $this->db->where('gr_comparacao_salarial.id',$id);

        return $this->db->get()->row_array();
    }

    #========================== Formula Calculo ======================================
    public function create_formula_calculo($data)
    {
        return $this->db->insert('gr_formula_calculo', $data);
    }
    public function get_formula_calculo()
    {
        return $this->db->get('gr_formula_calculo')->result_array();
    }
    public function get_formula_calculo_filter($id)
    {
        return $this->db->get_where('gr_formula_calculo', ['id' => $id])->row_array();
    }

    #================= Calculo Salario ==============================================
    public function create_calculo_salario($data)
    {
        return $this->db->insert('gr_calculo_salario', $data);
    }
    public function get_calculo_salario()
    {
        $this->db->select('
       gr_calculo_salario.*,
       staff.firstname as primeiro_nome,
       staff.lastname as segundo_nome,
       gr_faixa_salarial.salario_min,
       gr_faixa_salarial.salario_max,
   ');
        $this->db->from('gr_calculo_salario');
        $this->db->join('staff', 'staff.staffid = gr_calculo_salario.staff_id', 'left');
        $this->db->join('gr_faixa_salarial', 'gr_faixa_salarial.id = gr_calculo_salario.faixa_salarial_id', 'left');

        //$pacote_beneficio = $this->db->get()->result_array();
        return $this->db->get()->result_array();
    }
    public function get_calculo_salario_filter($id)
    {
        $this->db->select('
       gr_calculo_salario.*,
       staff.firstname as primeiro_nome,
       staff.lastname as segundo_nome,
       gr_faixa_salarial.salario_min,
       gr_faixa_salarial.salario_max,
   ');
        $this->db->from('gr_calculo_salario');
        $this->db->join('staff', 'staff.staffid = gr_calculo_salario.staff_id', 'left');
        $this->db->join('gr_faixa_salarial', 'gr_faixa_salarial.id = gr_calculo_salario.faixa_salarial_id', 'left');
        $this->db->where('gr_calculo_salario.id', $id);
        //$pacote_beneficio = $this->db->get()->result_array();
        return $this->db->get()->row_array();
    }

    #========================== Arquivo Pagamento ======================================
    public function create_arquivo_pagamento($data)
    {
        return $this->db->insert('gr_arquivo_pagamento', $data);
    }
    public function get_arquivo_pagamento()
    {
        return $this->db->get('gr_arquivo_pagamento')->result_array();
    }
    public function get_arquivo_pagamento_filter($id)
    {
        return $this->db->get_where('gr_arquivo_pagamento', ['id' => $id])->row_array();
    }

    #=============================== Banco ===================================
    public function get_banco()
    {
        return $this->db->get('gr_banco')->result_array();
    }
    public function create_banco($data)
    {
        $vf_existe = $this->db->get_where('gr_banco', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "Banco já foi cadastrada");
            redirect('gestao_remuneracao/configuracoes?group=banco');
        }
        return $this->db->insert('gr_banco', $data);
    }
    public function first_banco($id)
    {
        $query = $this->db->get_where('gr_banco', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_banco($data, $id)
    {
        $this->first_banco($id);
        $vf_existe = $this->db->get_where('gr_banco', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Banco já foi cadastrada");
                redirect('gestao_remuneracao/configuracoes?group=banco');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gr_banco', $data);

        return $this->first_banco($id);
    }
    public function delete_banco($id)
    {
        $first = $this->first_banco($id);
        $this->db->where('id', $id);
        $this->db->delete('gr_banco');
        return $first;
    }
    public function verificar_relacionamento_banco($id)
    {
        $this->db->where("banco_id", $id);
        $query = $this->db->get("gdi_avaliacao");

        return $query->row() !== null;
    }

    #================================ Processamento PAgamento =======================================
    public function create_processamento_pagamento($data)
    {
        return $this->db->insert('gr_processamento_pagamento', $data);
    }
    public function verificar_relacionamento_processamento_pagamento($id)
    {

        $this->db->where("mentoria_id", $id);
        $query = $this->db->get("gdi_plano_desenvolvimento");

        return $query->row() !== null;
    }
    public function get_processamento_pagamento()
    {
        $this->db->select('
         gr_processamento_pagamento.*,
         gr_status.status AS status_nome,
         gr_status.id AS status_id,
         staff.firstname as primeiro_nome,
         staff.lastname as segundo_nome,
         gr_banco.nome as banco,
     ');
        $this->db->from('gr_processamento_pagamento');
        $this->db->join('gr_status', 'gr_status.id = gr_processamento_pagamento.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_processamento_pagamento.staff_id', 'left');
        $this->db->join('gr_banco', 'gr_banco.id = gr_processamento_pagamento.banco_id', 'left');

        $valores = $this->db->get()->result_array();

        foreach ($valores as &$valore) {
            $aprovadores_ids = json_decode($valore['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $valore['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $valore['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($valore);

        return $valores;
    }

    public function first_processamento_pagamento($id)
    {
        $this->db->select('
        gr_processamento_pagamento.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome,
        gr_banco.nome as banco,
    ');
        $this->db->from('gr_processamento_pagamento');
        $this->db->join('gr_status', 'gr_status.id = gr_processamento_pagamento.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_processamento_pagamento.staff_id', 'left');
        $this->db->join('gr_banco', 'gr_banco.id = gr_processamento_pagamento.banco_id', 'left');
        $this->db->where('gr_processamento_pagamento.id', $id);

        $valorer = $this->db->get()->row_array();
        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }

        return $valorer;
    }

    public function processamento_pagamento_update($data, $id)
    {
        $this->first_processamento_pagamento($id);
        $this->db->where('id', $id);
        $this->db->update('gr_processamento_pagamento', $data);
        return $this->first_processamento_pagamento($id);
    }



    public function get_filtered_processamento_pagamento($funcionario = null, $status = null)
    {
        $this->db->select('
         gdi_mentoria.*,
         gdi_status.status AS status_nome,
         gdi_status.id AS status_id,
         staff.firstname as primeiro_nome,
         staff.lastname as segundo_nome
         ');
        $this->db->from('gdi_mentoria');
        $this->db->join('gdi_status', 'gdi_status.id = gdi_mentoria.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gdi_mentoria.staff_id', 'left');

        // Filtrar por funcionário
        if (!empty($funcionario)) {
            $this->db->where('gdi_mentoria.staff_id', $funcionario);
        }

        // Filtrar por status
        if (!empty($status)) {
            $this->db->where('gdi_mentoria.status_id', $status);
        }

        $valores = $this->db->get()->result_array();

        foreach ($valores as &$valor) {
            $aprovadores_ids = json_decode($valor['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $valor['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $valor['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($valor);

        return $valores;
    }
    #========================== Regalacao Fiscal ======================================
    public function create_regulacao_fiscal($data)
    {
        return $this->db->insert('gr_regulacao_fiscal', $data);
    }
    public function get_regulacao_fiscal()
    {
        return $this->db->get('gr_regulacao_fiscal')->result_array();
    }

    public function get_regulacao_fiscal_filter($id)
    {
        return $this->db->get_where('gr_regulacao_fiscal', ['id' => $id])->row_array();
    }
    #================================ Documento Auditoria =======================================
    public function create_documento_auditoria($data)
    {
        return $this->db->insert('gr_documento_auditoria', $data);
    }
    /*  public function verificar_relacionamento_documento_auditoria($id)
     {

         $this->db->where("mentoria_id", $id);
         $query = $this->db->get("gdi_documento_auditoria");

         return $query->row() !== null;
     } */
    public function get_documento_auditoria()
    {
        $this->db->select('
        gr_documento_auditoria.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
    ');
        $this->db->from('gr_documento_auditoria');
        $this->db->join('gr_status', 'gr_status.id = gr_documento_auditoria.status_id', 'left');

        $valores = $this->db->get()->result_array();

        foreach ($valores as &$valore) {
            $aprovadores_ids = json_decode($valore['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $valore['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $valore['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($valore);

        return $valores;
    }

    public function first_documento_auditoria($id)
    {
        $this->db->select('
        gr_documento_auditoria.*,
        gr_status.status AS status_nome,
        gr_status.id AS status_id,
    ');
        $this->db->from('gr_documento_auditoria');
        $this->db->join('gr_status', 'gr_status.id = gr_documento_auditoria.status_id', 'left');
        $this->db->where('gr_documento_auditoria.id', $id);

        $valorer = $this->db->get()->row_array();
        $aprovadores_ids = json_decode($valorer['aprovadores'], true);

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $valorer['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $valorer['aprovadores_nomes'] = "Nenhum";
        }
        return $valorer;
    }

    public function documento_auditoria_update($data, $id)
    {
        $this->first_documento_auditoria($id);
        $this->db->where('id', $id);
        $this->db->update('gr_documento_auditoria', $data);
        return $this->first_documento_auditoria($id);
    }

    /* public function get_filtered_documento_auditoria($funcionario = null, $status = null)
    {
        $this->db->select('
        gdi_mentoria.*,
        gdi_status.status AS status_nome,
        gdi_status.id AS status_id,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome
        ');
        $this->db->from('gdi_mentoria');
        $this->db->join('gdi_status', 'gdi_status.id = gdi_mentoria.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gdi_mentoria.staff_id', 'left');

        // Filtrar por funcionário
        if (!empty($funcionario)) {
            $this->db->where('gdi_mentoria.staff_id', $funcionario);
        }

        // Filtrar por status
        if (!empty($status)) {
            $this->db->where('gdi_mentoria.status_id', $status);
        }

        $valores = $this->db->get()->result_array();

        foreach ($valores as &$valor) {
            $aprovadores_ids = json_decode($valor['aprovadores'], true);

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();


                $valor['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $valor['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($valor);

        return $valores;
    } */

    #======================= Vencimento Funcionaio======================
    public function get_vencimento_funcionario()
    {
        $this->db->select('
         gr_vencimento_funcionario.*,
         staff.firstname as primeiro_nome,
         staff.lastname as segundo_nome
        ');
        $this->db->from('gr_vencimento_funcionario');
        $this->db->join('staff', 'staff.staffid = gr_vencimento_funcionario.staff_id', 'left');
        return $this->db->get()->result_array();
    }
    public function get_vencimento_funcionario_filter($id)
    {
        $this->db->select('
         gr_vencimento_funcionario.*,
         staff.firstname as primeiro_nome,
         staff.lastname as segundo_nome
        ');
        $this->db->from('gr_vencimento_funcionario');
        $this->db->join('staff', 'staff.staffid = gr_vencimento_funcionario.staff_id', 'left');
        $this->db->where('gr_vencimento_funcionario.id', $id);
        return $this->db->get()->row_array();
    }
    public function create_vencimento_funcionario($data)
    {
        return $this->db->insert('gr_vencimento_funcionario', $data);
    }

    #======================= Subsidio De Ferias======================
    public function get_subsidio_ferias()
    {
        $this->db->select('
          gr_subsidio_ferias.*,
          staff.firstname as primeiro_nome,
          staff.lastname as segundo_nome
         ');
        $this->db->from('gr_subsidio_ferias');
        $this->db->join('staff', 'staff.staffid = gr_subsidio_ferias.staff_id', 'left');
        return $this->db->get()->result_array();
    }
    public function get_subsidio_ferias_filter($id)
    {
        $this->db->select('
          gr_subsidio_ferias.*,
          staff.firstname as primeiro_nome,
          staff.lastname as segundo_nome
         ');
        $this->db->from('gr_subsidio_ferias');
        $this->db->join('staff', 'staff.staffid = gr_subsidio_ferias.staff_id', 'left');
        $this->db->where('gr_subsidio_ferias.id', $id);
        return $this->db->get()->row_array();
    }

    public function create_subsidio_ferias($data)
    {
        return $this->db->insert('gr_subsidio_ferias', $data);
    }

    #======================= Subsidio De Natal ======================
    public function get_subsidio_natal()
    {
        $this->db->select('
           gr_subsidio_natal.*,
           staff.firstname as primeiro_nome,
           staff.lastname as segundo_nome
          ');
        $this->db->from('gr_subsidio_natal');
        $this->db->join('staff', 'staff.staffid = gr_subsidio_natal.staff_id', 'left');
        return $this->db->get()->result_array();
    }
    public function get_subsidio_natal_filter($id)
    {
        $this->db->select('
           gr_subsidio_natal.*,
           staff.firstname as primeiro_nome,
           staff.lastname as segundo_nome
          ');
        $this->db->from('gr_subsidio_natal');
        $this->db->join('staff', 'staff.staffid = gr_subsidio_natal.staff_id', 'left');
        $this->db->where('gr_subsidio_natal.id', $id);
        return $this->db->get()->row_array();
    }
    public function create_subsidio_natal($data)
    {
        return $this->db->insert('gr_subsidio_natal', $data);
    }

    #======================= Recisão De Contrato ======================
    public function get_rescisao_contrato()
    {
        $this->db->select('
           gr_rescisao_contrato.*,
           staff.firstname as primeiro_nome,
           staff.lastname as segundo_nome
          ');
        $this->db->from('gr_rescisao_contrato');
        $this->db->join('staff', 'staff.staffid = gr_rescisao_contrato.staff_id', 'left');
      
      return $this->db->get()->result_array();
    }
    public function get_rescisao_contrato_filter($id)
    {
        $this->db->select('
           gr_rescisao_contrato.*,
           staff.firstname as primeiro_nome,
           staff.lastname as segundo_nome
          ');
        $this->db->from('gr_rescisao_contrato');
        $this->db->join('staff', 'staff.staffid = gr_rescisao_contrato.staff_id', 'left');
        $this->db->where('gr_rescisao_contrato.id', $id);
      return $this->db->get()->row_array();
    }
    public function create_rescisao_contrato($data)
    {
        return $this->db->insert('gr_rescisao_contrato', $data);
    }

    #======================= Relatoriosalario ======================
    public function get_relatorio_salario()
    {
        return $this->db->get('gr_relatorio_salario')->result_array();
    }
    public function get_relatorio_salario_filter($id)
    {
        return $this->db->get_where('gr_relatorio_salario', ['id' => $id])->row_array();
    }

    public function create_relatorio_salario($data)
    {
        return $this->db->insert('gr_relatorio_salario', $data);
    }

    #======================= Recisão De Contrato ======================
    public function get_analise_custo()
    {
        $this->db->select('
           gr_analise_custo.*,
           departments.name as departamento
          ');
        $this->db->from('gr_analise_custo');
        $this->db->join('departments', 'departments.departmentid = gr_analise_custo.departamento_id', 'left');
        return $this->db->get()->result_array();
    }
    public function get_analise_custo_filter($id)
    {
        $this->db->select('
           gr_analise_custo.*,
           departments.name as departamento
          ');
        $this->db->from('gr_analise_custo');
        $this->db->join('departments', 'departments.departmentid = gr_analise_custo.departamento_id', 'left');
        $this->db->where('gr_analise_custo.id',$id);
        return $this->db->get()->row_array();
    }

    public function create_analise_custo($data)
    {
        return $this->db->insert('gr_analise_custo', $data);
    }

    #======================= Relatorio Equidade Salarial ======================
    public function get_relatorio_equidade_salarial()
    {
        return $this->db->get('gr_relatorio_equidade_salarial')->result_array();
    }

    public function get_relatorio_equidade_salarial_filter($id)
    {
        return $this->db->get_where('gr_relatorio_equidade_salarial', ['id' => $id])->row_array();
    }
    public function create_relatorio_equidade_salarial($data)
    {
        return $this->db->insert('gr_relatorio_equidade_salarial', $data);
    }
   
    #======================= Relatorio Equidade Salarial ======================
    public function get_relatorio_previsao()
    {
        return $this->db->get('gr_relatorio_previsao')->result_array();
    }
    public function get_relatorio_previsao_filter($id)
    {
        return $this->db->get_where('gr_relatorio_previsao', ['id' => $id])->row_array();
    }

    public function create_relatorio_previsao($data)
    {
        return $this->db->insert('gr_relatorio_previsao', $data);
    }

    #======================= Mapa INSS ======================
    public function get_mapa_inss()
    {
        return $this->db->get('gr_mapa_inss')->result_array();
    }
    public function get_mapa_inss_filter($id)
    {
        return $this->db->get_where('gr_mapa_inss', ['id' => $id])->row_array();
    }

    public function create_mapa_inss($data)
    {
        return $this->db->insert('gr_mapa_inss', $data);
    }

    #======================= Mapa IRT ======================
    public function get_mapa_irt()
    {
        return $this->db->get('gr_mapa_irt')->result_array();
    }
    public function get_mapa_irt_filter($id)
    {
        return $this->db->get_where('gr_mapa_irt', ['id' => $id])->row_array();
    }

    public function create_mapa_irt($data)
    {
        return $this->db->insert('gr_mapa_irt', $data);
    }


    // contadores
    public function contar_faixa_salarial()
    {
        return $this->db->count_all('gr_faixa_salarial');
    }
    public function contar_brenchmark()
    {
        return $this->db->count_all('gr_benchmark_salarial');
    }
    public function contar_comparacao()
    {
        return $this->db->count_all('gr_comparacao_salarial');
    }
    public function contar_relatorio_comparativo()
    {
        return $this->db->count_all('gr_relatorio_comparativo');
    }

    public function contar_subsidio_ferias()
    {
        return $this->db->count_all('gr_subsidio_ferias');
    }

    public function contar_dados_ajuste_salarial()
    {
        // Conta o total de registros
        $this->db->select('COUNT(*) as total_registros');
        $this->db->from('gr_ajuste_salarial');
        $total = $this->db->get()->row()->total_registros;

        // Conta por status
        $this->db->select('status_id, COUNT(*) as total');
        $this->db->from('gr_ajuste_salarial');
        $this->db->where_in('status_id', [1, 2, 3]);
        $this->db->group_by('status_id');
        $status = $this->db->get()->result_array();

        // Define os valores padrão
        $resultados = [
            'total_registros' => $total,
            'pendentes' => 0,
            'aprovados' => 0,
            'rejeitados' => 0
        ];

        // Mapeia os valores do banco
        foreach ($status as $row) {
            if ($row['status_id'] == 1) {
                $resultados['pendentes'] = $row['total'];
            } elseif ($row['status_id'] == 2) {
                $resultados['aprovados'] = $row['total'];
            } elseif ($row['status_id'] == 3) {
                $resultados['rejeitados'] = $row['total'];
            }
        }

        return $resultados;
    }

    public function processamento_pagamento_valores()
    {
        $this->db->select('
            gr_processamento_pagamento.valor,
            staff.firstname as primeiro_nome,
            staff.lastname as segundo_nome
        ');
        $this->db->order_by("gr_processamento_pagamento.valor", "DESC"); // Ordenação do maior para o menor
        $this->db->join('staff', 'staff.staffid = gr_processamento_pagamento.staff_id', 'left');
        $query = $this->db->get("gr_processamento_pagamento");

        return $query->result_array();
    }

    public function bonus_valores()
    {
        $this->db->select('
            gr_calculo_salario.bonus,
            staff.firstname as primeiro_nome,
            staff.lastname as segundo_nome
        ');
        $this->db->order_by("gr_calculo_salario.bonus", "DESC"); // Ordenação do maior para o menor
        $this->db->join('staff', 'staff.staffid = gr_calculo_salario.staff_id', 'left');
        $query = $this->db->get("gr_calculo_salario");

        return $query->result_array();
    }

    public function contar_dados_pacote_beneficio()
    {
        // Conta o total de registros
        $this->db->select('COUNT(*) as total_registros');
        $this->db->from('gr_pacote_beneficio');
        $total = $this->db->get()->row()->total_registros;

        // Conta por status
        $this->db->select('status_id, COUNT(*) as total');
        $this->db->from('gr_pacote_beneficio');
        $this->db->where_in('status_id', [1, 2, 3]);
        $this->db->group_by('status_id');
        $status = $this->db->get()->result_array();

        // Define os valores padrão
        $resultados = [
            'total_registros' => $total,
            'pendentes' => 0,
            'aprovados' => 0,
            'rejeitados' => 0
        ];

        // Mapeia os valores do banco
        foreach ($status as $row) {
            if ($row['status_id'] == 1) {
                $resultados['pendentes'] = $row['total'];
            } elseif ($row['status_id'] == 2) {
                $resultados['aprovados'] = $row['total'];
            } elseif ($row['status_id'] == 3) {
                $resultados['rejeitados'] = $row['total'];
            }
        }

        return $resultados;
    }

}