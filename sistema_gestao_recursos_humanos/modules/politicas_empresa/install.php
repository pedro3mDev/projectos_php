<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Requisitos para Politica
if (!$CI->db->table_exists(db_prefix() . 'pe_tipo_politica')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_tipo_politica` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `tipo_politica` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'pe_area')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_area` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `area` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'pe_categoria')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_categoria` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `categoria` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'pe_status')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `status` varchar(100) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'pe_nivel_hierarquico')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_nivel_hierarquico` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `nivel_hierarquico` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
// Fim Requisitos para Politica

// Politica
if (!$CI->db->table_exists(db_prefix() . 'pe_politica')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_politica` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `status_id` int(11) NOT NULL,
      `categoria_id` int(11) NOT NULL,
      `tipo_politica_id` int(11) NOT NULL,
      `area_id` int(11) NOT NULL,
      `nivel_hierarquico_id` int(11) NOT NULL,
      `titulo` varchar(100) NOT NULL,
      `descricao` text NOT NULL,
      `arquivo` varchar(255) NULL DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('status_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    DROP `status_id`
  ;");
}
if ($CI->db->field_exists('area_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    DROP `area_id`
  ;");
}
if ($CI->db->field_exists('nivel_hierarquico_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    DROP `nivel_hierarquico_id`
  ;");
}
if (!$CI->db->field_exists('status' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente' AFTER `arquivo`
  ;");
}
if (!$CI->db->field_exists('aprovadores' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `aprovadores` text NULL
  ;");
}
if (!$CI->db->field_exists('conselho_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `conselho_id` int(11) NOT NULL
  ;");
}
if (!$CI->db->field_exists('pelorio_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `pelorio_id` int(11) NULL DEFAULT NULL
  ;");
}
if (!$CI->db->field_exists('direcao_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `direcao_id` int(11) NULL DEFAULT NULL
  ;");
}
if (!$CI->db->field_exists('departamento_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `departamento_id` int(11) NULL DEFAULT NULL
  ;");
}
if (!$CI->db->field_exists('seccao_id' ,db_prefix() . 'pe_politica')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_politica`
    ADD COLUMN `seccao_id` int(11) NULL DEFAULT NULL
  ;");
}

if (!$CI->db->table_exists(db_prefix() . 'pe_revisao')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_revisao` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `politica_id` int(11) NOT NULL,
      `descricao` text NOT NULL,
      `alteracao` text NOT NULL,
      `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente',
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

// Conformidade
if (!$CI->db->table_exists(db_prefix() . 'pe_conformidade')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_conformidade` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `staff_conformidade_id` int(11) NOT NULL,
      `politica_id` int(11) NOT NULL,
      `observacao` text NOT NULL,
      `data_verificacao` date NOT NULL,
      `arquivo` varchar(255) NULL DEFAULT NULL,
      `status` enum('pendente','aprovado','rejeitado') NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('status' ,db_prefix() . 'pe_conformidade')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_conformidade`
    CHANGE COLUMN `status` `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente'
  ;");
}
if (!$CI->db->field_exists('aprovadores' ,db_prefix() . 'pe_conformidade')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_conformidade`
    ADD COLUMN `aprovadores` text NULL
  ;");
}

// Requisitos para o Procedimentos
if (!$CI->db->table_exists(db_prefix() . 'pe_tipo_procedimento')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_tipo_procedimento` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `tipo_procedimento` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
// Fim Requisitos para o Procedimentos

//  Procedimentos
if (!$CI->db->table_exists(db_prefix() . 'pe_procedimento')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_procedimento` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `staff_procedimento_id` int(11) NOT NULL,
      `tipo_procedimento_id` int(11) NOT NULL,
      `politica_id` int(11) NOT NULL,
      `procedimento` varchar(255) NOT NULL,
      `descricao` text NULL DEFAULT NULL,
      `arquivo` varchar(255) NULL DEFAULT NULL,
      `status` enum('pendente','aprovado','rejeitado') NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('status' ,db_prefix() . 'pe_procedimento')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_procedimento`
    ADD COLUMN `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente'
  ;");
}
if (!$CI->db->field_exists('aprovadores' ,db_prefix() . 'pe_procedimento')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_procedimento`
    ADD COLUMN `aprovadores` text NULL
  ;");
}
if (!$CI->db->field_exists('processo_id' ,db_prefix() . 'pe_procedimento')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_procedimento`
    ADD COLUMN `processo_id` int(11) NOT NULL
  ;");
}

if (!$CI->db->table_exists(db_prefix() . 'pe_probabilidade')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_probabilidade` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `probabilidade` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('staff_id' ,db_prefix() . 'pe_probabilidade')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_probabilidade`
    DROP `staff_id`
  ;");
}
if ($CI->db->field_exists('probabilidade' ,db_prefix() . 'pe_probabilidade')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_probabilidade`
    CHANGE COLUMN `probabilidade` `valor_probabilidade` int(11) NOT NULL
  ;");
}

if (pl_valor_probabilidade_exists(1) == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'pe_probabilidade` (`descricao`,`valor_probabilidade`) VALUES ("Muito Baixa", 1);
  ');
}
if (pl_valor_probabilidade_exists(2) == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'pe_probabilidade` (`descricao`,`valor_probabilidade`) VALUES ("Baixa", 2);
');
}
if (pl_valor_probabilidade_exists(3) == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'pe_probabilidade` (`descricao`,`valor_probabilidade`) VALUES ("Moderada", 3);
');
}
if (pl_valor_probabilidade_exists(4) == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'pe_probabilidade` (`descricao`,`valor_probabilidade`) VALUES ("Alta", 4);
');
}
if (pl_valor_probabilidade_exists(5) == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'pe_probabilidade` (`descricao`,`valor_probabilidade`) VALUES ("Muito Alta", 5);
');
}

if (!$CI->db->table_exists(db_prefix() . 'pe_impacto')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_impacto` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `impacto` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if ($CI->db->field_exists('descricao' ,db_prefix() . 'pe_impacto')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_impacto`
    CHANGE COLUMN `descricao` `valor_impacto` int(11) NOT NULL
  ;");
}
if (pl_valor_impacto_exists(1) == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'pe_impacto` (`impacto`,`valor_impacto`) VALUES ("Muito Baixa", 1);
');
}
if (pl_valor_impacto_exists(2) == 0){
$CI->db->query('INSERT INTO `'.db_prefix().'pe_impacto` (`impacto`,`valor_impacto`) VALUES ("Baixa", 2);
');
}
if (pl_valor_impacto_exists(3) == 0){
$CI->db->query('INSERT INTO `'.db_prefix().'pe_impacto` (`impacto`,`valor_impacto`) VALUES ("Moderada", 3);
');
}
if (pl_valor_impacto_exists(4) == 0){
$CI->db->query('INSERT INTO `'.db_prefix().'pe_impacto` (`impacto`,`valor_impacto`) VALUES ("Alta", 4);
');
}
if (pl_valor_impacto_exists(5) == 0){
$CI->db->query('INSERT INTO `'.db_prefix().'pe_impacto` (`impacto`,`valor_impacto`) VALUES ("Muito Alta", 5);
');
}
// Fim Requisitos para o Risco

// Risco
if (!$CI->db->table_exists(db_prefix() . 'pe_risco')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_risco` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `politica_id` int(11) NOT NULL,
      `impacto_id` int(11) NOT NULL,
      `descricao` text NOT NULL,
      `arquivo` varchar(255) NULL DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('status' ,db_prefix() . 'pe_risco')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_risco`
    ADD COLUMN `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente' AFTER `arquivo`
  ;");
}
if (!$CI->db->field_exists('aprovadores' ,db_prefix() . 'pe_risco')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_risco`
    ADD COLUMN `aprovadores` text NULL
  ;");
}
if (!$CI->db->field_exists('medidas_metigacao' ,db_prefix() . 'pe_risco')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_risco`
    ADD COLUMN `medidas_metigacao` text NOT NULL
  ;");
}

if (!$CI->db->field_exists('probabilidade_id' ,db_prefix() . 'pe_risco')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_risco`
    ADD COLUMN `probabilidade_id` int(11) NOT NULL
  ;");
}

if (!$CI->db->table_exists(db_prefix() . 'pe_norma')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_norma` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `norma` varchar(100) NOT NULL,
      `descricao` TEXT DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'pe_comunicacao')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_comunicacao` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `politica_id` int(11) NOT NULL,
      `colaborador_id` int(11) NOT NULL,
      `arquivo` varchar(255) NULL DEFAULT NULL,
      `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente',
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('data_verificacao' ,db_prefix() . 'pe_comunicacao')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_comunicacao`
    ADD COLUMN `data_verificacao` date NOT NULL
  ;");
}
if ($CI->db->field_exists('arquivo' ,db_prefix() . 'pe_comunicacao')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_comunicacao`
    CHANGE COLUMN `arquivo` `arquivo` VARCHAR(255) NULL DEFAULT NULL
  ;");
}

if (!$CI->db->table_exists(db_prefix() . 'pe_processo')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_processo` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `politica_id` int(11) NOT NULL,
      `colaborador_id` int(11) NOT NULL,
      `titulo` varchar(255) NOT NULL,
      `descricao` text NOT NULL,
      `arquivo` varchar(255) NULL DEFAULT NULL,
      `aprovadores` text NOT NULL,
      `data_verificacao` date NOT NULL,
      `status` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente',
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

// if (!$CI->db->table_exists(db_prefix() . 'pe_categoria_politica')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_categoria_politica` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `categoria_id` int(11) NOT NULL,
//       `politica_id` int(11) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_acesso')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_acesso` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `politica_id` int(11) NOT NULL,
//       `acao` enum('acessou','alterou') NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_termo')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_termo` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `politica_id` int(11) NOT NULL,
//       `tipo_termo` enum('confirmidade','confidencialidade') NOT NULL,
//       `data_assinatura` date NOT NULL,
//       `arquivo` varchar(255) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if ($CI->db->field_exists('arquivo' ,db_prefix() . 'pe_termo')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_termo`
//     CHANGE COLUMN `arquivo` `arquivo` VARCHAR(255) NULL DEFAULT NULL
//   ;");
// }
// if ($CI->db->field_exists('tipo_termo' ,db_prefix() . 'pe_termo')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_termo`
//     CHANGE COLUMN `tipo_termo` `tipo_termo` enum('conformidade','confidencialidade') NOT NULL
//   ;");
// }

// if (!$CI->db->field_exists('tipo_assinatura' ,db_prefix() . 'pe_termo')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_termo`
//     ADD COLUMN `tipo_assinatura` enum('fisico','digital') NOT NULL AFTER `data_assinatura`
//   ;");
// }

// if (!$CI->db->table_exists(db_prefix() . 'pe_categoria_assets')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_categoria_assets` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `categoria` varchar(100) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'pe_fornecedor')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_fornecedor` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `nome` varchar(100) NOT NULL,
//       `nif` varchar(100) NOT NULL,
//       `localizacao` varchar(255) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_assets')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_assets` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `categoria_assets_id` int(11) NOT NULL,
//       `fornecedor_id` int(11) NOT NULL,
//       `nome` varchar(255) NOT NULL,
//       `data_aquisicao` date NOT NULL,
//       `valor_aquisicao` decimal(10,0) DEFAULT NULL,
//       `data_inicial_uso` date NOT NULL,
//       `data_desativacao` date DEFAULT NULL,
//       `status` enum('em_uso','novo') NOT NULL,
//       `vida_util` int(11) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_ciclo_vida')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_ciclo_vida` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `assets_id` int(11) NOT NULL,
//       `fase` enum('aquisicao','operacao','manutencao','desativacao') NOT NULL,
//       `status` enum('ativo','concluido','em_andamento') NOT NULL,
//       `data_inicio` datetime NOT NULL,
//       `data_fim` datetime DEFAULT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_manutencao')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_manutencao` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `assets_id` int(11) NOT NULL,
//       `ciclo_vida_id` int(11) NOT NULL,
//       `descricao` text NOT NULL,
//       `tipo` enum('preventiva','correctiva') NOT NULL,
//       `data_manutencao` date NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_localizacao_assets')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_localizacao_assets` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `nome` varchar(100) NOT NULL,
//       `descricao` varchar(255) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->field_exists('localizacao' ,db_prefix() . 'pe_localizacao_assets')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_localizacao_assets`
//     CHANGE `nome` `localizacao` VARCHAR(255) NOT NULL
//   ;");
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_movimentacao')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_movimentacao` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `assets_id` int(11) NOT NULL,
//       `ciclo_vida_id` int(11) NOT NULL,
//       `localizacao_assets_origem_id` int(11) NOT NULL,
//       `localizacao_assets_destino_id` int(11) NOT NULL,
//       `data_movimento` datetime NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'pe_conduta')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_conduta` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `nome` varchar(100) NOT NULL,
//       `descricao` text NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_conduta_adesao')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_conduta_adesao` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `conduta_id` int(11) NOT NULL,
//       `metodo_aceite` enum('assinatura_digital','assinatura_fisica') NOT NULL,
//       `arquivo` varchar(255) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if ($CI->db->field_exists('arquivo' ,db_prefix() . 'pe_conduta_adesao')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_conduta_adesao`
//     CHANGE COLUMN `arquivo` `arquivo` VARCHAR(255) NULL DEFAULT NULL
//   ;");
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_conduta_violacao')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_conduta_violacao` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `conduta_id` int(11) NOT NULL,
//       `acao_tomada` varchar(255) NOT NULL,
//       `data_ocorrencia` date NOT NULL,
//       `status` enum('ativo','resolvido') NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'pe_conduta_treinamento')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_conduta_treinamento` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `conduta_id` int(11) NOT NULL,
//       `data_treinemento` date NOT NULL,
//       `status` enum('ativo','finalizado') NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if ($CI->db->field_exists('data_treinemento' ,db_prefix() . 'pe_conduta_treinamento')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_conduta_treinamento`
//     CHANGE COLUMN `data_treinemento` `data_treinamento` date NOT NULL
//   ;");
// }
// if ($CI->db->field_exists('status' ,db_prefix() . 'pe_conduta_treinamento')) {
//   $CI->db->query('ALTER TABLE `' . db_prefix() . "pe_conduta_treinamento`
//     CHANGE COLUMN `status` `status` enum('ativo','finalizado','pendente') NOT NULL
//   ;");
// }
// if (!$CI->db->table_exists(db_prefix() . 'pe_conduta_treinamento_staff')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "pe_conduta_treinamento_staff` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `staff_id` int(11) NOT NULL,
//       `conduta_treinamento_id` int(11) NOT NULL,
//       `resultado` enum('aprovado','reprovado', 'pendente') NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }