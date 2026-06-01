<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'psl_status')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status` varchar(200) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (psl_status_exists('Pendente') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_status` (`status`) VALUES ("Pendente");
    ');
}
if (psl_status_exists('Aprovado') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_status` (`status`) VALUES ("Aprovado");
    ');
}
if (psl_status_exists('Rejeitado') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_status` (`status`) VALUES ("Rejeitado");
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_desempenho')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_desempenho` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (psl_desempenho_exists('Pessimo') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_desempenho` (`nome`,`descricao`) VALUES ("Pessimo", "Pessimo Desempenho");
    ');
}
if (psl_desempenho_exists('Mau') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_desempenho` (`nome`,`descricao`) VALUES ("Mau", "Mau Desempenho");
    ');
}
if (psl_desempenho_exists('Razoável') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_desempenho` (`nome`,`descricao`) VALUES ("Razoável", "Desempenho Razoável");
    ');
}
if (psl_desempenho_exists('Bom') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_desempenho` (`nome`,`descricao`) VALUES ("Bom", "Bom Desempenho");
    ');
}
if (psl_desempenho_exists('Excelente') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_desempenho` (`nome`,`descricao`) VALUES ("Excelente", "Excelente Desempenho");
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_potencial')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_potencial` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (psl_potencial_exists('Pequeno') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_potencial` (`nome`,`descricao`) VALUES ("Pequeno", "Pequeno Potencial");
    ');
}
if (psl_potencial_exists('Medio') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_potencial` (`nome`,`descricao`) VALUES ("Medio", "Potencial Medio");
    ');
}
if (psl_potencial_exists('Alto') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_potencial` (`nome`,`descricao`) VALUES ("Alto", "Potencial Alto");
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'psl_nivel_critico')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_nivel_critico` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (psl_nivel_critico_exists('Pequeno') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_nivel_critico` (`nome`,`descricao`) VALUES ("Pequeno", "Pequeno Nivel");
    ');
}
if (psl_nivel_critico_exists('Medio') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_nivel_critico` (`nome`,`descricao`) VALUES ("Medio", "Nivel Medio");
    ');
}
if (psl_nivel_critico_exists('Alto') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_nivel_critico` (`nome`,`descricao`) VALUES ("Alto", "Nivel Alto");
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_feedback')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_feedback` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (psl_feedback_exists('Pessimo') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_feedback` (`nome`,`descricao`) VALUES ("Pessimo", "Pessimo Desempenho");
    ');
}
if (psl_feedback_exists('Mau') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_feedback` (`nome`,`descricao`) VALUES ("Mau", "Mau Desempenho");
    ');
}
if (psl_feedback_exists('Razoável') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_feedback` (`nome`,`descricao`) VALUES ("Razoável", "Desempenho Razoável");
    ');
}
if (psl_feedback_exists('Bom') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_feedback` (`nome`,`descricao`) VALUES ("Bom", "Bom Desempenho");
    ');
}
if (psl_feedback_exists('Excelente') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_feedback` (`nome`,`descricao`) VALUES ("Excelente", "Excelente Desempenho");
    ');
}


if (!$CI->db->table_exists(db_prefix() . 'psl_competencia')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_competencia` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_talento')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_talento` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `potencial_id` int(11) NOT NULL,
        `desempenho_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'psl_talento_competencia')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_talento_competencia` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `talento_id` int(11) NOT NULL,
        `competencia_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_avaliacao_competencia')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_avaliacao_competencia` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `competencia_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `nota` decimal(10,2) NOT NULL,
        `data_avaliacao` date NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'psl_potencial_desenvolvimento')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_potencial_desenvolvimento` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `potencial_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `sugestao_desenvolvimento` text NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_mapa_sucessao')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_mapa_sucessao` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `cargo_id` int(11) NOT NULL,
        `competencia_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('staff_id' ,db_prefix() . 'psl_mapa_sucessao')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_mapa_sucessao` DROP `staff_id`;");
}
if (!$CI->db->table_exists(db_prefix() . 'psl_plano_desenvolvimento')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_plano_desenvolvimento` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `competencia_id` int(11) NOT NULL,
        `treinamento_sugerido` text NOT NULL,
        `status_id` int(11) NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('competencia_id' ,db_prefix() . 'psl_plano_desenvolvimento')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_plano_desenvolvimento` DROP `competencia_id`;");
}
if (!$CI->db->field_exists('mapa_sucessao_id' ,db_prefix() . 'psl_plano_desenvolvimento')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_plano_desenvolvimento`
      ADD COLUMN `mapa_sucessao_id` int(11) NOT NULL
    ;");
}
if (!$CI->db->field_exists('posicao_chave_id' ,db_prefix() . 'psl_plano_desenvolvimento')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_plano_desenvolvimento`
      ADD COLUMN `posicao_chave_id` int(11) NOT NULL
    ;");
}
if (!$CI->db->table_exists(db_prefix() . 'psl_posicao_chave')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_posicao_chave` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `nivel_critico_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_programa_lideranca')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_programa_lideranca` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `data_inicio` date NOT NULL,
        `data_fim` date NOT NULL,
        `status_id` int(11) NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_treinamento_lideranca')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_treinamento_lideranca` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `programa_lideranca_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `carga_horaria` int NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_avaliacao_lideranca')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_avaliacao_lideranca` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `treinamento_lideranca_id` int(11) NOT NULL,
        `feedback_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `nota` decimal(10,2) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('staff_id' ,db_prefix() . 'psl_avaliacao_lideranca')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_avaliacao_lideranca`
      CHANGE COLUMN `staff_id` `talento_id` int(11) NOT NULL
    ;");
}
if ($CI->db->field_exists('nota' ,db_prefix() . 'psl_avaliacao_lideranca')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_avaliacao_lideranca`
      CHANGE COLUMN `nota` `nota` int(11) NOT NULL
    ;");
}

if (!$CI->db->table_exists(db_prefix() . 'psl_competencia_cargo')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_competencia_cargo` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `competencia_id` int(11) NOT NULL,
        `cargo_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'psl_plano_aquisicao_competencia')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_plano_aquisicao_competencia` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `competencia_id` int(11) NOT NULL,
        `data_prevista` date NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_mentoria')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_mentoria` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `mentor_id` int(11) NOT NULL,
        `mentorado_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `feedback` text NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_coaching')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_coaching` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `coach_id` int(11) NOT NULL,
        `staff_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `objetivo` text NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_feedback_lideranca')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_feedback_lideranca` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `mentor_id` int(11) NOT NULL,
        `staff_id` int(11) NOT NULL,
        `comentario` text NOT NULL,
        `data_feedback` date NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_impacto')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_impacto` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (psl_impacto_exists('Pequeno') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_impacto` (`nome`,`descricao`) VALUES ("Pequeno", "Pequeno Impacto");
    ');
}
if (psl_impacto_exists('Medio') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_impacto` (`nome`,`descricao`) VALUES ("Medio", "Impacto Medio");
    ');
}
if (psl_impacto_exists('Grande') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_impacto` (`nome`,`descricao`) VALUES ("Grande", "Grande Impacto");
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_nivel_risco')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_nivel_risco` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` TEXT DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (psl_nivel_risco_exists('Pequeno') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_nivel_risco` (`nome`,`descricao`) VALUES ("Pequeno", "Nivel de Risco Pequeno");
    ');
}
if (psl_nivel_risco_exists('Medio') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_nivel_risco` (`nome`,`descricao`) VALUES ("Medio", "Nivel de Risco Medio");
    ');
}
if (psl_nivel_risco_exists('Alto') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'psl_nivel_risco` (`nome`,`descricao`) VALUES ("Alto", "Alto Nivel de Risco");
    ');
}


if (!$CI->db->table_exists(db_prefix() . 'psl_risco_sucessao')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_risco_sucessao` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `cargo_id` int(11) NOT NULL,
        `nivel_risco_id` int(11) NOT NULL,
        `impacto_id` int(11) NOT NULL,
        `plano_contingencia` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_impacto_perda_talento')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_impacto_perda_talento` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `impacto_id` int(11) NOT NULL,
        `sugestao_mitigacao` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_programa_retencao')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_programa_retencao` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `beneficio` text NOT NULL,
        `feedback` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('staff_id' ,db_prefix() . 'psl_programa_retencao')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_programa_retencao`
      CHANGE COLUMN `staff_id` `estrategia_engajamento_id` int(11) NOT NULL
    ;");
}

if (!$CI->db->table_exists(db_prefix() . 'psl_avaliacao_nivel')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_avaliacao_nivel` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `avaliacao_competencia_id` int(11) NOT NULL,
        `potencial_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'psl_estrategia_engajamento')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "psl_estrategia_engajamento` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `estrategia` text NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('staff_id' ,db_prefix() . 'psl_estrategia_engajamento')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "psl_estrategia_engajamento`
      CHANGE COLUMN `staff_id` `talento_id` int(11) NOT NULL
    ;");
}