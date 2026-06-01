<?php

defined('BASEPATH') or exit('No direct script access allowed');

#================================= Tabela Status ===============================================

if (!$CI->db->table_exists(db_prefix() . 'gr_status')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gr_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status` varchar(200) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (gr_status_exists('Pendente') == 0) {
    $CI->db->query('INSERT INTO `' . db_prefix() . 'gr_status` (`status`) VALUES ("Pendente");
    ');
}
if (gr_status_exists('Aprovado') == 0) {
    $CI->db->query('INSERT INTO `' . db_prefix() . 'gr_status` (`status`) VALUES ("Aprovado");
    ');
}
if (gr_status_exists('Rejeitado') == 0) {
    $CI->db->query('INSERT INTO `' . db_prefix() . 'gr_status` (`status`) VALUES ("Rejeitado");
    ');
}

#========================= Tabelas Ciclo de Revisão Salarial ==================================================
if (!$CI->db->table_exists(db_prefix() . 'gr_ciclo_revisao_salarial')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_ciclo_revisao_salarial (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            periodicidade VARCHAR(200) NOT NULL,
            data_inicio DATE NOT NULL,
            data_fim DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
#========================= Ajuste Salarial ======================================
if (!$CI->db->table_exists(db_prefix() . 'gr_ajuste_salarial')) {
    $CI->db->query('CREATE TABLE ' . db_prefix() . 'gr_ajuste_salarial (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            percentual_aumento VARCHAR(200) NOT NULL,
            motivo Varchar(200) NOT NULL,
            status_id INT(11) NOT NULL,
            staff_id INT(11) NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=========================== Relatorio Comparativo ============================================
if (!$CI->db->table_exists(db_prefix() . 'gr_relatorio_comparativo')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_relatorio_comparativo (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            data_geracao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=========================== Pacote Beneficio ============================================
if (!$CI->db->table_exists(db_prefix() . 'gr_pacote_beneficio')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_pacote_beneficio (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            elegibilidade VARCHAR(200) NOT NULL,
            status_id INT(11) UNSIGNED NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gr_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#===========================Beneficio Funcionario============================================
if (!$CI->db->table_exists(db_prefix() . 'gr_beneficio_funcionario')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_beneficio_funcionario (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            data_inicio DATE NOT NULL,
            data_fim DATE NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            beneficio_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (beneficio_id) REFERENCES ' . db_prefix() . 'gr_pacote_beneficio(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=========================== Alterar Beneficio ============================================
if (!$CI->db->table_exists(db_prefix() . 'gr_alterar_beneficio')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_alterar_beneficio (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            beneficio_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (beneficio_id) REFERENCES ' . db_prefix() . 'gr_pacote_beneficio(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
#=========================== Solicitação Beneficio ============================================
if (!$CI->db->table_exists(db_prefix() . 'gr_solicitacao_beneficio')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_solicitacao_beneficio (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            data_solicitacao DATE NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            beneficio_id INT(11) UNSIGNED NOT NULL,
            status_id INT(11) UNSIGNED NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (beneficio_id) REFERENCES ' . db_prefix() . 'gr_pacote_beneficio(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gr_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#========================= Tabelas Tipo de Categoria ==================================================
if (!$CI->db->table_exists(db_prefix() . 'gr_tipo_categoria')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gr_tipo_categoria` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(200) NOT NULL,
        `descricao` varchar(200) NULL DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
#============================== Benchmark Salarial ========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_benchmark_salarial')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_benchmark_salarial (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            setor VARCHAR(200) NOT NULL,
            nivel_experiencia VARCHAR(200) NOT NULL,
            media_salarial FLOAT NOT NULL,
            data_referencia DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
#=================================== Faixa SAlarrial ===========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_faixa_salarial')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_faixa_salarial (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            salario_min FLOAT NOT NULL,
            salario_max FLOAT NOT NULL,
            data_atualizacao DATE NOT NULL,
            cargo_id INT(11) UNSIGNED NOT NULL,
            tipo_categoria_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (cargo_id) REFERENCES ' . db_prefix() . 'hr_job_position(position_id ) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (tipo_categoria_id) REFERENCES ' . db_prefix() . 'gr_tipo_categoria(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=================================== Comparação Salarrial ===========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_comparacao_salarial')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_comparacao_salarial (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            diferenca_percentual FLOAT NOT NULL,
            benchmark_salarial_id INT(11) UNSIGNED NOT NULL,
            faixa_salarial_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (benchmark_salarial_id) REFERENCES ' . db_prefix() . 'gr_benchmark_salarial(id ) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (faixa_salarial_id) REFERENCES ' . db_prefix() . 'gr_faixa_salarial(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#============================ Formula calculo ========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_formula_calculo')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_formula_calculo (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao TEXT DEFAULT NULL,
            regra VARCHAR(200) NOT NULL,
            data_atualizacao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=================================== Calculo Salarrial ===========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_calculo_salario')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_calculo_salario (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            bonus FLOAT NOT NULL,
            descontos FLOAT NOT NULL,
            salario_final FLOAT NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            faixa_salarial_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (faixa_salarial_id) REFERENCES ' . db_prefix() . 'gr_faixa_salarial(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#============================ Formula calculo ========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_arquivo_pagamento')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_arquivo_pagamento (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao TEXT DEFAULT NULL,
            formato VARCHAR(200) NOT NULL,
            data_exportacao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#============================ Banco ========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_banco')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_banco (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            nome VARCHAR(200) NOT NULL,
            descricao TEXT DEFAULT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#============================ Processamento Pagamento ========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_processamento_pagamento')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_processamento_pagamento (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            valor FLOAT NOT NULL,
            data_pagamento DATE NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            banco_id INT(11) UNSIGNED NOT NULL,
            status_id INT(11) UNSIGNED NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (banco_id) REFERENCES ' . db_prefix() . 'gr_banco(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gr_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#============================ Regulação Fiscal ========================================
if (!$CI->db->table_exists(db_prefix() . 'gr_regulacao_fiscal')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_regulacao_fiscal (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao TEXT DEFAULT NULL,
            legislacao_aplicavel INT(11) NOT NULL,
            data_atualizacao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
#=============================== Documento de Auditoria =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_documento_auditoria')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_documento_auditoria (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            tipo_documento VARCHAR(200) NOT NULL,
            data_geracao DATE NOT NULL,
            status_id INT(11) UNSIGNED NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gr_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Vencimento Funcionario =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_vencimento_funcionario')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_vencimento_funcionario (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            salario_base FLOAT NOT NULL,
            bonus FLOAT NOT NULL,
            beneficios FLOAT NOT NULL,
            salario_liquido FLOAT NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Subsidio de Ferias =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_subsidio_ferias')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_subsidio_ferias (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            valor FLOAT NOT NULL,
            data_pagamento DATE NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Subsidio de Natal =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_subsidio_natal')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_subsidio_natal (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            valor FLOAT NOT NULL,
            data_pagamento DATE NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Rescisao Contrato =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_rescisao_contrato')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_rescisao_contrato (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            indiminizacao FLOAT NOT NULL,
            ferias_vencidas INT(11) NOT NULL,
            total_pago FLOAT NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Relatorio Salario =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_relatorio_salario')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_relatorio_salario (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            data_geracao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Analise Custo =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_analise_custo')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_analise_custo (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            custo_total FLOAT NOT NULL,
            data_referencia DATE NOT NULL,
            departamento_id INT(11) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (departamento_id) REFERENCES ' . db_prefix() . 'departments(departmentid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Relatorio Equitado Salarial =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_relatorio_equidade_salarial')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_relatorio_equidade_salarial (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            analise_genero VARCHAR(200) NOT NULL,
            analise_idade VARCHAR(200) NOT NULL,
            disparidade_identificada VARCHAR(200) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Relatorio Previsão =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_relatorio_previsao')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_relatorio_previsao (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            impacto_financeiro VARCHAR(200) NOT NULL,
            data_geracao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== MApa INSS =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_mapa_inss')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_mapa_inss (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            data_envio DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== MApa IRT =================================
if (!$CI->db->table_exists(db_prefix() . 'gr_mapa_irt')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'gr_mapa_irt (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao VARCHAR(200) DEFAULT NULL,
            data_envio DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

