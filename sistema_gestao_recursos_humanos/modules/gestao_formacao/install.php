<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'gf_status')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status` varchar(200) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (gf_status_exists('Pendente') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gf_status` (`status`) VALUES ("Pendente");
    ');
}
if (gf_status_exists('Aprovado') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gf_status` (`status`) VALUES ("Aprovado");
    ');
}
if (gf_status_exists('Rejeitado') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gf_status` (`status`) VALUES ("Rejeitado");
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_nivel_risco')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_nivel_risco` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `valor` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (gf_nivel_risco_exists('Pequeno') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gf_nivel_risco` (`nome`,`descricao`,`valor`) VALUES ("Pequeno", "Nivel de Risco Pequeno", 1);
    ');
}
if (gf_nivel_risco_exists('Medio') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gf_nivel_risco` (`nome`,`descricao`,`valor`) VALUES ("Medio", "Nivel de Risco Medio", 2);
    ');
}
if (gf_nivel_risco_exists('Alto') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gf_nivel_risco` (`nome`,`descricao`,`valor`) VALUES ("Alto", "Alto Nivel de Risco", 3);
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_competencia')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_competencia` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_impacto_qualitativo')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_impacto_qualitativo` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `valor` int(11) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_impacto_quantitativo')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_impacto_quantitativo` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `valor` int(11) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_categoria')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_categoria` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

// if (!$CI->db->table_exists(db_prefix() . 'gf_curso')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_curso` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `status_id` int(11) NOT NULL,
//         `categoria_id` int(11) NOT NULL,
//         `nome` varchar(100) NOT NULL,
//         `descricao` TEXT DEFAULT NULL,
//         `carga_horaria` int(11) NOT NULL,
//         `publico_alvo` TEXT DEFAULT NULL,
//         `requisitos` TEXT DEFAULT NULL,
//         `aprovadores` TEXT DEFAULT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//         PRIMARY KEY (`id`),
//         FOREIGN KEY (`status_id`) REFERENCES `".db_prefix()."gf_status`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
//         FOREIGN KEY (`categoria_id`) REFERENCES `".db_prefix()."gf_categoria`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
if (!$CI->db->table_exists(db_prefix() . 'gf_curso')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_curso (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            status_id int(11) UNSIGNED NOT NULL,
            categoria_id int(11) UNSIGNED NOT NULL,
            nome varchar(100) NOT NULL,
            descricao TEXT DEFAULT NULL,
            carga_horaria int(11) NOT NULL,
            publico_alvo TEXT DEFAULT NULL,
            requisitos TEXT DEFAULT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (categoria_id) REFERENCES ' . db_prefix() . 'gf_categoria(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_vaga')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gf_vaga` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `curso_id` int(11) UNSIGNED NOT NULL,
        `total_vagas` int(11) NOT NULL,
        `data_inicio` date NOT NULL,
        `data_fim` date NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`curso_id`) REFERENCES `".db_prefix()."gf_curso`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_inscricao')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_inscricao (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            vaga_id int(11) UNSIGNED NOT NULL,
            staff_id int(11) NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            data_inscricao date NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (vaga_id) REFERENCES ' . db_prefix() . 'gf_vaga(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_historico_formacao')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_historico_formacao (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            staff_id int(11) NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            data_inscricao date NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_avaliacao')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_avaliacao (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            vaga_id int(11) UNSIGNED NOT NULL,
            inscricao_id int(11) UNSIGNED NOT NULL,
            nota int(11) UNSIGNED NOT NULL,
            data_avaliacao date NOT NULL,
            comentario TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (vaga_id) REFERENCES ' . db_prefix() . 'gf_vaga(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (inscricao_id) REFERENCES ' . db_prefix() . 'gf_inscricao(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_relatorio_impacto')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_relatorio_impacto (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            impacto_qualitativo_id int(11) UNSIGNED NOT NULL,
            impacto_quantitativo_id int(11) UNSIGNED NOT NULL,
            data_relatorio date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (impacto_qualitativo_id) REFERENCES ' . db_prefix() . 'gf_impacto_qualitativo(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (impacto_quantitativo_id) REFERENCES ' . db_prefix() . 'gf_impacto_quantitativo(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_planejamento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_planejamento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            orcamento_previsto decimal(10,2) NOT NULL,
            orcamento_realizado decimal(10,2) NOT NULL,
            data_planejamento date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_roi')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_roi (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            custo decimal(10,2) NOT NULL,
            beneficio decimal(10,2) NOT NULL,
            retorno decimal(10,2) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_risco')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_risco (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            nivel_risco_id int(11) UNSIGNED NOT NULL,
            descricao TEXT NOT NULL,
            data_identificacao date NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (nivel_risco_id) REFERENCES ' . db_prefix() . 'gf_nivel_risco(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_conformidade')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_conformidade (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            requisitos_regulatorios TEXT NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_compotencia_curso')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_compotencia_curso (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            competencia_id int(11) UNSIGNED NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (competencia_id) REFERENCES ' . db_prefix() . 'gf_competencia(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_competencia_usuario')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_competencia_usuario (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            staff_id int(11) NOT NULL,
            competencia_id int(11) UNSIGNED NOT NULL,
            nivel varchar(255) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (competencia_id) REFERENCES ' . db_prefix() . 'gf_competencia(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_curso_personalizado')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_curso_personalizado (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            staff_id int(11) NOT NULL,
            curso_id int(11) UNSIGNED NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            adaptacoes varchar(255) NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_recrutamento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_recrutamento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            vaga_id int(11) UNSIGNED NOT NULL,
            staff_id int(11) NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (vaga_id) REFERENCES ' . db_prefix() . 'gf_vaga(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_aval_desempenho')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_aval_desempenho (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            competencia_id int(11) UNSIGNED NOT NULL,
            recrutamento_id int(11) UNSIGNED NOT NULL,
            nota int(11) UNSIGNED NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (competencia_id) REFERENCES ' . db_prefix() . 'gf_competencia(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (recrutamento_id) REFERENCES ' . db_prefix() . 'gf_recrutamento(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_conformidade_regulatoria')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_conformidade_regulatoria (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            normas TEXT NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_certificado_acreditacao')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_certificado_acreditacao (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            entidade_acreditadora TEXT NOT NULL,
            validade date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_plataforma_ead')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_plataforma_ead (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            status_id int(11) UNSIGNED NOT NULL,
            nome varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            url varchar(255) NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_acessibilidade')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_acessibilidade (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            descricao TEXT NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gf_suporte')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_suporte (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            staff_id int(11) NOT NULL,
            status_id int(11) UNSIGNED NOT NULL,
            tipo_suporte varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            data_registro date NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gf_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gf_recurso')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gf_recurso (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            curso_id int(11) UNSIGNED NOT NULL,
            tipo_recurso varchar(255) NOT NULL,
            url TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (curso_id) REFERENCES ' . db_prefix() . 'gf_curso(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}