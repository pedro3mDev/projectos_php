<?php

defined('BASEPATH') or exit('No direct script access allowed');


#================================= Tabela Status ===============================================
if (!$CI->db->table_exists(db_prefix() . 'gdi_status')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status` varchar(200) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (gdi_status_exists('Pendente') == 0) {
  $CI->db->query('INSERT INTO `' . db_prefix() . 'gdi_status` (`status`) VALUES ("Pendente");
    ');
}
if (gdi_status_exists('Aprovado') == 0) {
  $CI->db->query('INSERT INTO `' . db_prefix() . 'gdi_status` (`status`) VALUES ("Aprovado");
    ');
}
if (gdi_status_exists('Rejeitado') == 0) {
  $CI->db->query('INSERT INTO `' . db_prefix() . 'gdi_status` (`status`) VALUES ("Rejeitado");
    ');
}

#========================= Tabelas Avaliação ==================================================
if (!$CI->db->table_exists(db_prefix() . 'gdi_tipo_avaliacao')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_tipo_avaliacao` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `descricao` varchar(200) NULL DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gdi_avaliacao')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_avaliacao` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `meta` varchar(200) NOT NULL,
      `descricao` varchar(200) NULL DEFAULT NULL,
      `data_fim` date NOT NULL,
      `prazo` date NOT NULL,
      `pontuacao` int(200) NOT NULL,
      `status_id` int(11) NOT NULL,
      `aprovadores` text NOT NULL,
      `staf_id` int(11) NOT NULL,
      `tipo_avaliacao_id` int(11) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#============================ Tabelas Mentoria  =====================================================

if (!$CI->db->table_exists(db_prefix() . 'gdi_mentoria')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_mentoria` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `descricao` varchar(200) NULL DEFAULT NULL,
    `data_seccao` date NOT NULL,
    `feedback` varchar(200) NOT NULL,
    `status_id` int(11) NOT NULL,
    `staff_id` int(11) NOT NULL,
    `aprovadores` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#============================ Tabelas Planos =====================================================
if (!$CI->db->table_exists(db_prefix() . 'gdi_plano_desenvolvimento')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_plano_desenvolvimento` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `meta` varchar(200) NOT NULL,
    `descricao` varchar(200) NULL DEFAULT NULL,
    `prazo` date NOT NULL,
    `data_fim` date NOT NULL,
    `pontuacao_recomendado` int(11) NOT NULL,
    `mentoria_id` int(11) NOT NULL,
    `avaliacao_id` int(11) NOT NULL,
    `status_id` int(11) NOT NULL,
    `aprovadores` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

#============================ Tabelas Carreira =====================================================
if (!$CI->db->table_exists(db_prefix() . 'gdi_tipo_habilidade')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_tipo_habilidade` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `descricao` varchar(200) NULL DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gdi_carreira')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gdi_carreira` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `descricao` varchar(200) NULL DEFAULT NULL,
    `data_seccao` date NOT NULL,
    `programa_rotacao` BOOLEAN DEFAULT TRUE,
    `habilidade_id` TEXT NOT NULL,
    `plano_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

$CI->db->query("ALTER TABLE " . db_prefix() . "gdi_carreira MODIFY COLUMN habilidade_id TEXT NOT NULL");
//$CI->db->query("ALTER TABLE " . db_prefix() . "gdi_carreira CHANGE COLUMN programa_rotacao programa_rotacao BOOLEAN DEFAULT TRUE");
