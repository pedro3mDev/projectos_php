<?php

defined('BASEPATH') or exit('No direct script access allowed');

#================================= Tabela Status ===============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_status')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "pft_status` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `status` varchar(200) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (pft_status_exists('Pendente') == 0) {
    $CI->db->query('INSERT INTO `' . db_prefix() . 'pft_status` (`status`) VALUES ("Pendente");
      ');
}
if (pft_status_exists('Aprovado') == 0) {
    $CI->db->query('INSERT INTO `' . db_prefix() . 'pft_status` (`status`) VALUES ("Aprovado");
      ');
}
if (pft_status_exists('Rejeitado') == 0) {
    $CI->db->query('INSERT INTO `' . db_prefix() . 'pft_status` (`status`) VALUES ("Rejeitado");
      ');
}

#========================= Tabelas Avaliação ==================================================
if (!$CI->db->table_exists(db_prefix() . 'pft_tipo_planeamento')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "pft_tipo_planeamento` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(200) NOT NULL,
        `descricao` varchar(200) NULL DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#===========================Planeamento============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_planeamento_recursos')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_planeamento_recursos (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            previsao_demanda VARCHAR(200) NOT NULL,
            data_criacao DATE NOT NULL,
            tipo_planeamento_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (tipo_planeamento_id) REFERENCES ' . db_prefix() . 'pft_tipo_planeamento(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}


#========================= Tabelas Competência ==================================================
if (!$CI->db->table_exists(db_prefix() . 'pft_competencia')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "pft_competencia` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(200) NOT NULL,
        `descricao` varchar(200) NULL DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#===========================Competencia Funcionario============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_competencia_funcionario')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_competencia_funcionario (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            nivel VARCHAR(200) NOT NULL,
            competencia_id INT(11) UNSIGNED NOT NULL,
            staff_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (competencia_id) REFERENCES ' . db_prefix() . 'pft_competencia(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#===========================Necessidade Pessoal============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_necessidade_pessoal')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_necessidade_pessoal (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            descricao TEXT DEFAULT NULL,
            quantidade INT(200) NOT NULL,
            prazo DATE NOT NULL,
            departamento_id INT(11) NOT NULL,
            status_id INT(11) UNSIGNED NOT NULL,
            aprovadores text NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (departamento_id) REFERENCES ' . db_prefix() . 'departments(departmentid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'pft_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}


#========================= Simulação =====================================
if (!$CI->db->table_exists(db_prefix() . 'pft_simulacao')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_simulacao (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            impacto_previsto TEXT NOT NULL,
            descricao TEXT DEFAULT NULL,
            data_criacao DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}


#========================= Plano ==================================================
if (!$CI->db->table_exists(db_prefix() . 'pft_plano')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "pft_plano` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(200) NOT NULL,
        `descricao` varchar(200) NULL DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}


#===========================Necessidade Pessoal============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_monitoramento_plano')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_monitoramento_plano (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            kpi_avaliado VARCHAR(200) NOT NULL,
            resultado VARCHAR(200) NOT NULL,
            data_registro DATE NOT NULL,
            plano_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (plano_id) REFERENCES ' . db_prefix() . 'pft_plano(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#======================== Recurso Ajustado ===================================
if (!$CI->db->table_exists(db_prefix() . 'pft_recurso_ajustado')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "pft_recurso_ajustado` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(200) NOT NULL,
        `descricao` varchar(200) NULL DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#=============================== Ajuste ============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_ajuste')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_ajuste (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            kpi_impactado VARCHAR(200) NOT NULL,
            anotacao VARCHAR(200) NOT NULL,
            motivo VARCHAR(200) NOT NULL,
            data DATE NOT NULL,
            recurso_id INT(11) UNSIGNED NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (recurso_id) REFERENCES ' . db_prefix() . 'pft_recurso_ajustado(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}


#=============================== Integração ============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_integracao')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_integracao (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            valor INT(11) NOT NULL,
            data_pagamento DATE NOT NULL,
            staff_id INT(11)  NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}


#======================== Tipo Previsao ===================================
if (!$CI->db->table_exists(db_prefix() . 'pft_tipo_previsao')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "pft_tipo_previsao` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(200) NOT NULL,
        `descricao` varchar(200) NULL DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#=============================== Integração ============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_previsao')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_previsao (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            dado_entrada VARCHAR(200) NOT NULL,
            resultado_previsao VARCHAR(200) NOT NULL,
            data DATE NOT NULL,
            tipo_previsao_id INT(11) UNSIGNED NOT NULL,
            departamento_id INT(11) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (tipo_previsao_id) REFERENCES ' . db_prefix() . 'pft_tipo_previsao(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (departamento_id) REFERENCES ' . db_prefix() . 'departments(departmentid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

#=============================== Projeto ============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_projeto')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_projeto (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            nome VARCHAR(200) NOT NULL,
            descricao VARCHAR(200) DEFAULT NULL,
            staff_id INT(11) NOT NULL,
            status_id INT(11) UNSIGNED NOT NULL,
            aprovadores text NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'pft_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}


#=============================== Alocação ============================================
if (!$CI->db->table_exists(db_prefix() . 'pft_alocacao')) {
    $CI->db->query(' CREATE TABLE ' . db_prefix() . 'pft_alocacao (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            data_inicio DATE NOT NULL,
            data_fim DATE NOT NULL,
            staff_id INT(11) NOT NULL,
            projeto_id INT(11) UNSIGNED NOT NULL,
            aprovadores text NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (projeto_id) REFERENCES ' . db_prefix() . 'pft_projeto(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}