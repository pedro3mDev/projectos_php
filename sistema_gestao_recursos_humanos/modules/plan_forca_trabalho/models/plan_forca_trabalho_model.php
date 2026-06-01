<?php

defined('BASEPATH') or exit('No direct script access allowed');

class plan_forca_trabalho_model extends App_Model
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
        return $this->db->get('pft_status')->result_array();
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
    public function get_comparativo_relatorio_filter($id)
    {
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
        $this->db->where('gr_beneficio_funcionario.id', $id);
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
        $this->db->where('gr_alterar_beneficio.id', $id);
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
        $this->db->where('gr_comparacao_salarial.id', $id);
        $this->db->where('gr_comparacao_salarial.id', $id);

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

    #=============================== tipo plenamento ===================================
    public function get_tipo_planeamto()
    {
        return $this->db->get('pft_tipo_planeamento')->result_array();
    }
    public function create_tipo_planeamento($data)
    {
        $vf_existe = $this->db->get_where('pft_tipo_planeamento', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "Plano já foi cadastrada");
            redirect('gestao_remuneracao/configuracoes?group=banco');
        }
        return $this->db->insert('pft_tipo_planeamento', $data);
    }
    public function first_tipo_planeamento($id)
    {
        $query = $this->db->get_where('pft_tipo_planeamento', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_tipo_planeamento($data, $id)
    {
        $this->first_tipo_planeamento($id);
        $vf_existe = $this->db->get_where('pft_tipo_planeamento', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Plano já foi cadastrada");
                redirect('gestao_remuneracao/configuracoes?group=banco');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pft_tipo_planeamento', $data);

        return $this->first_tipo_planeamento($id);
    }
    public function delete_tipo_planeamento($id)
    {
        $first = $this->first_tipo_planeamento($id);
        $this->db->where('id', $id);
        $this->db->delete('pft_tipo_planeamento');
        return $first;
    }
    public function verificar_relacionamento_banco($id)
    {
        $this->db->where("banco_id", $id);
        $query = $this->db->get("pft_tipo_planeamento");

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
         tipo_planeamento.nome as banco,
     ');
        $this->db->from('gr_processamento_pagamento');
        $this->db->join('gr_status', 'gr_status.id = gr_processamento_pagamento.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_processamento_pagamento.staff_id', 'left');
        $this->db->join('tipo_planeamento', 'tipo_planeamento.id = gr_processamento_pagamento.banco_id', 'left');

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
        tipo_planeamento.nome as banco,
    ');
        $this->db->from('gr_processamento_pagamento');
        $this->db->join('gr_status', 'gr_status.id = gr_processamento_pagamento.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = gr_processamento_pagamento.staff_id', 'left');
        $this->db->join('tipo_planeamento', 'tipo_planeamento.id = gr_processamento_pagamento.banco_id', 'left');
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
        $this->db->where('gr_analise_custo.id', $id);
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


    /* ***
        Planeamento CRUDE
    */
    #========================= Planeamento ================================
    public function create_planeamento($data)
    {
        return $this->db->insert('pft_planeamento_recursos', $data);
    }
    public function get_planeamento()
    {
        // Buscar as avaliações com informações básicas
        $this->db->select('
             pft_planeamento_recursos.*,
             pft_tipo_planeamento.nome AS tipo_nome,
             pft_tipo_planeamento.id AS tipo_id
         ');
        $this->db->from('pft_planeamento_recursos');
        $this->db->join('pft_tipo_planeamento', 'pft_tipo_planeamento.id = pft_planeamento_recursos.tipo_planeamento_id', 'left');

        return $this->db->get()->result_array();
    }

    #===============================Competencia ===================================
    public function get_competencia()
    {
        return $this->db->get('pft_competencia')->result_array();
    }
    public function create_competencia($data)
    {
        $vf_existe = $this->db->get_where('pft_competencia', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "competencia já foi cadastrada");
            redirect('Plan_forca_trabalho/configuracoes?group=competencia');
        }
        return $this->db->insert('pft_competencia', $data);
    }
    public function first_competencia($id)
    {
        $query = $this->db->get_where('pft_competencia', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_competencia($data, $id)
    {
        $this->first_competencia($id);
        $vf_existe = $this->db->get_where('pft_competencia', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Tipo Competencia já foi cadastrada");
                redirect('Plan_forca_trabalho/configuracoes?group=competencia');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pft_competencia', $data);

        return $this->first_competencia($id);
    }
    public function delete_competencia($id)
    {
        $first = $this->first_competencia($id);
        $this->db->where('id', $id);
        $this->db->delete('pft_competencia');
        return $first;
    }



    /* ***
        Competencia Funcionario CRUDE
    */
    #========================= Competencia Funcionario ================================
    public function create_competencia_funcionario($data)
    {
        return $this->db->insert('pft_competencia_funcionario', $data);
    }
    public function get_competencia_funcionario()
    {
        // Buscar as avaliações com informações básicas
        $this->db->select('
             pft_competencia_funcionario.*,
             pft_competencia.nome AS tipo_nome,
             pft_competencia.id AS tipo_id,
             staff.firstname as primeiro_nome,
             staff.lastname as segundo_nome,
         ');
        $this->db->from('pft_competencia_funcionario');
        $this->db->join('pft_competencia', 'pft_competencia.id = pft_competencia_funcionario.competencia_id', 'left');
        $this->db->join('staff', 'staff.staffid = pft_competencia_funcionario.staff_id', 'left');
        return $this->db->get()->result_array();
    }


    /**
     * 
     * Analise CRUD
     * 
     */

    #========================= Analise ================================
    public function get_analise()
    {
        // Buscar as avaliações com informações básicas
        $this->db->select('
            pft_necessidade_pessoal.*,
            pft_status.status AS status_nome,
            pft_status.id AS status_id,
            departments.name AS tipo_nome,
            departments.departmentid AS tipo_id
        ');
        $this->db->from('pft_necessidade_pessoal');
        $this->db->join('pft_status', 'pft_status.id = pft_necessidade_pessoal.status_id', 'left');
        $this->db->join('departments', 'departments.departmentid = pft_necessidade_pessoal.departamento_id', 'left');

        $analises = $this->db->get()->result_array();

        // Buscar os nomes dos aprovadores para cada avaliação
        foreach ($analises as &$analise) {
            $aprovadores_ids = json_decode($analise['aprovadores'], true); // Converte JSON para array

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();

                // Transforma o array de aprovadores em uma lista de nomes
                $analise['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $analise['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($analise);

        return $analises;
    }

    public function get_filtered_analise($tipo_departamento = null, $status = null)
    {
        $this->db->select('
            pft_necessidade_pessoal.*,
            pft_status.status AS status_nome,
            pft_status.id AS status_id,
            departments.name AS tipo_nome,
            departments.id AS tipo_id
    ');
        $this->db->from('gdi_avaliacao');
        $this->db->join('gdi_status', 'gdi_status.id = gdi_avaliacao.status_id', 'left');
        $this->db->join('gdi_tipo_avaliacao', 'gdi_tipo_avaliacao.id = gdi_avaliacao.tipo_avaliacao_id', 'left');
        $this->db->join('staff', 'staff.staffid = gdi_avaliacao.staf_id', 'left');

        // Aplicando filtros se forem fornecidos
        if (!empty($tipo_avaliacao)) {
            $this->db->where('gdi_avaliacao.tipo_avaliacao_id', $tipo_departamento);
        }

        if (!empty($status)) {
            $this->db->where('gdi_avaliacao.status_id', $status);
        }

        $avaliacoes = $this->db->get()->result_array();

        foreach ($avaliacoes as &$avaliacaoo) {
            $aprovadores_ids = !empty($avaliacaoo['aprovadores']) ? json_decode($avaliacaoo['aprovadores'], true) : [];

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();

                $avaliacaoo['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $avaliacaoo['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($avaliacaoo);

        return $avaliacoes;
    }
    public function analise_first($id)
    {
        $this->db->select('
            pft_necessidade_pessoal.*,
            pft_status.status AS status_nome,
            pft_status.id AS status_id,
            departments.name AS tipo_nome,
            departments.departmentid AS tipo_id
        ');
        $this->db->from('pft_necessidade_pessoal');
        $this->db->join('pft_status', 'pft_status.id = pft_necessidade_pessoal.status_id', 'left');
        $this->db->join('departments', 'departments.departmentid = pft_necessidade_pessoal.departamento_id', 'left');
        $this->db->where('pft_necessidade_pessoal.id', $id);

        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        $aprovadores_ids = !empty($query['aprovadores']) ? json_decode($query['aprovadores'], true) : [];

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $query['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $query['aprovadores_nomes'] = "Nenhum";
        }
        return $query;
    }

    public function analise_update($data, $id)
    {
        $this->analise_first($id);
        $this->db->where('id', $id);
        $this->db->update('pft_necessidade_pessoal', $data);
        return $this->analise_first($id);
    }
    public function create_analise($data)
    {
        return $this->db->insert('pft_necessidade_pessoal', $data);
    }

    /**
     * 
     * Simulacao CRUD
     * 
     */
    #========================= Simulação ================================
    public function create_simulacao($data)
    {
        return $this->db->insert('pft_simulacao', $data);
    }
    public function get_simulacao()
    {
        return $this->db->get('pft_simulacao')->result_array();
    }


    #=============================== Plano ===================================
    public function get_plano()
    {
        return $this->db->get('pft_plano')->result_array();
    }
    public function create_plano($data)
    {
        $vf_existe = $this->db->get_where('pft_plano', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "plano já foi cadastrada");
            redirect('Plan_forca_trabalho/configuracoes?group=plano');
        }
        return $this->db->insert('pft_plano', $data);
    }
    public function first_plano($id)
    {
        $query = $this->db->get_where('pft_plano', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_plano($data, $id)
    {
        $this->first_plano($id);
        $vf_existe = $this->db->get_where('pft_plano', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Plano já foi cadastrada");
                redirect('Plan_forca_trabalho/configuracoes?group=plano');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pft_plano', $data);

        return $this->first_plano($id);
    }
    public function delete_plano($id)
    {
        $first = $this->first_plano($id);
        $this->db->where('id', $id);
        $this->db->delete('pft_plano');
        return $first;
    }

    /**
     * 
     * Monitoramento CRUD
     */
    #==============================Monitoramento =========================
    public function create_monitoramento($data)
    {
        $this->db->insert('pft_monitoramento_plano', $data);
    }

    public function get_monitoramento()
    {
        $this->db->select('
        pft_monitoramento_plano.*,
        pft_plano.nome as tipo_plano,
        ');
        $this->db->from('pft_monitoramento_plano');
        $this->db->join('pft_plano', 'pft_plano.id = pft_monitoramento_plano.plano_id', 'left');

        return $this->db->get()->result_array();
    }


    /**
     * 
     * Recurso CRUD
     */
    #============================= Recurso ==============================================
    public function get_recurso()
    {
        return $this->db->get('pft_recurso_ajustado')->result_array();
    }
    public function create_recurso($data)
    {
        $vf_existe = $this->db->get_where('pft_recurso_ajustado', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "plano já foi cadastrada");
            redirect('Plan_forca_trabalho/configuracoes?group=recurso');
        }
        return $this->db->insert('pft_recurso_ajustado', $data);
    }
    public function first_recurso($id)
    {
        $query = $this->db->get_where('pft_recurso_ajustado', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_recurso($data, $id)
    {
        $this->first_recurso($id);
        $vf_existe = $this->db->get_where('pft_recurso_ajustado', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Recurso já foi cadastrada");
                redirect('Plan_forca_trabalho/configuracoes?group=recurso');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pft_recurso_ajustado', $data);

        return $this->first_recurso($id);
    }
    public function delete_recurso($id)
    {
        $first = $this->first_recurso($id);
        $this->db->where('id', $id);
        $this->db->delete('pft_recurso_ajustado');
        return $first;
    }

    /**
     * 
     * Ajuste CRUD
     * 
     */

    #============== Ajuste ============================
    public function create_ajuste($data)
    {
        return $this->db->insert('pft_ajuste', $data);
    }
    public function get_ajuste()
    {
        $this->db->select('
            pft_ajuste.*,
            pft_recurso_ajustado.nome as tipo_recurso,
        ');
        $this->db->from('pft_ajuste');
        $this->db->join('pft_recurso_ajustado', 'pft_recurso_ajustado.id = pft_ajuste.recurso_id', 'left');

        return $this->db->get()->result_array();
    }

    /**
     * 
     * Integração CRUD
     */
    #====================== Integração =============================
    public function create_integracao($data)
    {
        return $this->db->insert('pft_integracao', $data);
    }

    public function get_integracao()
    {
        $this->db->select('
        pft_integracao.*,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome,
        ');
        $this->db->from('pft_integracao');
        $this->db->join('staff', 'staff.staffid = pft_integracao.staff_id', 'left');

        return $this->db->get()->result_array();
    }

    /**
     * 
     * Tipo de Previsao CRUD
     * 
     */

    #=============================== Tipo de Previsao ===================================
    public function get_previsao()
    {
        return $this->db->get('pft_tipo_previsao')->result_array();
    }
    public function create_previsao($data)
    {
        $vf_existe = $this->db->get_where('pft_tipo_previsao', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger', "previsao já foi cadastrada");
            redirect('Plan_forca_trabalho/configuracoes?group=previsao');
        }
        return $this->db->insert('pft_tipo_previsao', $data);
    }
    public function first_previsao($id)
    {
        $query = $this->db->get_where('pft_tipo_previsao', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_previsao($data, $id)
    {
        $this->first_previsao($id);
        $vf_existe = $this->db->get_where('pft_tipo_previsao', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger', "Plano já foi cadastrada");
                redirect('Plan_forca_trabalho/configuracoes?group=previsao');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pft_tipo_previsao', $data);

        return $this->first_previsao($id);
    }
    public function delete_previsao($id)
    {
        $first = $this->first_previsao($id);
        $this->db->where('id', $id);
        $this->db->delete('pft_tipo_previsao');
        return $first;
    }

    /***
     * Previsao CRUD
     * 
     */
    #============================ Previsao =============================
    public function create_previsaos($data)
    {
        return $this->db->insert('pft_previsao', $data);
    }

    public function get_previsaos()
    {
        $this->db->select('
            pft_previsao.*,
            pft_tipo_previsao.nome as previsao,
            departments.name as departamento
        ');
        $this->db->from('pft_previsao');
        $this->db->join('pft_tipo_previsao', 'pft_tipo_previsao.id = pft_previsao.tipo_previsao_id', 'left');
        $this->db->join('departments', 'departments.departmentid = pft_previsao.departamento_id', 'left');

        return $this->db->get()->result_array();
    }



    /**
     * 
     * Projeto CRUD
     * 
     */

    #========================= Projeto ================================
    public function get_projeto()
    {
        // Buscar as avaliações com informações básicas
        $this->db->select('
            pft_projeto.*,
            pft_status.status as status_nome,
            pft_status.id as status_id,
            staff.firstname as primeiro_nome,
            staff.lastname as segundo_nome
        ');
        $this->db->from('pft_projeto');
        $this->db->join('pft_status', 'pft_status.id = pft_projeto.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = pft_projeto.staff_id', 'left');

        $projeto = $this->db->get()->result_array();

        // Buscar os nomes dos aprovadores para cada avaliação
        foreach ($projeto as &$dado) {
            $aprovadores_ids = json_decode($dado['aprovadores'], true); // Converte JSON para array

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();

                // Transforma o array de aprovadores em uma lista de nomes
                $dado['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $dado['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($dado);

        return $projeto;
    }

    public function get_filtered_projeto($tipo_departamento = null, $status = null)
    {
        $this->db->select('
            pft_projeto.*,
            pft_status.status as status_nome,
            pft_status.id as status_id,
            staff.firstname as primeiro_nome,
            staff.lastname as segundo_nome
    ');
        $this->db->from('pft_projeto');
        $this->db->join('pft_status', 'pft_status.id = pft_projeto.status_id', 'left');
        $this->db->join('staff', 'staff.satffid = pft_projeto.staff_id', 'left');

        // Aplicando filtros se forem fornecidos
        if (!empty($tipo_avaliacao)) {
            $this->db->where('pft_projeto.tipo_avaliacao_id', $tipo_departamento);
        }

        if (!empty($status)) {
            $this->db->where('gdi_avaliacao.status_id', $status);
        }

        $avaliacoes = $this->db->get()->result_array();

        foreach ($avaliacoes as &$avaliacaoo) {
            $aprovadores_ids = !empty($avaliacaoo['aprovadores']) ? json_decode($avaliacaoo['aprovadores'], true) : [];

            if (!empty($aprovadores_ids)) {
                $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
                $this->db->from("staff");
                $this->db->where_in("staffid", $aprovadores_ids);

                $result = $this->db->get()->result_array();

                $avaliacaoo['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
            } else {
                $avaliacaoo['aprovadores_nomes'] = "Nenhum";
            }
        }
        unset($avaliacaoo);

        return $avaliacoes;
    }
    public function projeto_first($id)
    {
        $this->db->select('
            pft_projeto.*,
            pft_status.status as status_nome,
            pft_status.id as status_id,
            staff.firstname as primeiro_nome,
            staff.lastname as segundo_nome
        ');
        $this->db->from('pft_projeto');
        $this->db->join('pft_status', 'pft_status.id = pft_projeto.status_id', 'left');
        $this->db->join('staff', 'staff.staffid = pft_projeto.staff_id', 'left');
        $this->db->where('pft_projeto.id', $id);

        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        $aprovadores_ids = !empty($query['aprovadores']) ? json_decode($query['aprovadores'], true) : [];

        if (!empty($aprovadores_ids)) {
            $this->db->select("staffid, CONCAT(firstname, ' ', lastname) as nome");
            $this->db->from("staff");
            $this->db->where_in("staffid", $aprovadores_ids);

            $result = $this->db->get()->result_array();

            $query['aprovadores_nomes'] = implode(", ", array_column($result, "nome"));
        } else {
            $query['aprovadores_nomes'] = "Nenhum";
        }
        return $query;
    }

    public function projeto_update($data, $id)
    {
        $this->projeto_first($id);
        $this->db->where('id', $id);
        $this->db->update('pft_projeto', $data);
        return $this->projeto_first($id);
    }
    public function create_projeto($data)
    {
        //dd($data);
        return $this->db->insert('pft_projeto', $data);
    }

    /**
     * 
     * Alocação CRUD
     */
    #================================ Alocação ================================
    public function create_alocacao($data)
    {
        return $this->db->insert('pft_alocacao', $data);
    }
    public function get_alocacao()
    {
        $this->db->select('
        pft_alocacao.*,
        staff.firstname as primeiro_nome,
        staff.lastname as segundo_nome,
        pft_projeto.nome projeto,
        ');

        $this->db->from('pft_alocacao');
        $this->db->join('staff', 'staff.staffid = pft_alocacao.staff_id', 'left');
        $this->db->join('pft_projeto', 'pft_projeto.id = pft_alocacao.projeto_id', 'left');
    
        return $this->db->get()->result_array();    
    }
}



