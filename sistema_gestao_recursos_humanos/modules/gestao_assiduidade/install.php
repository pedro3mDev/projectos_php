<?php

defined('BASEPATH') or exit('No direct script access allowed'); 
 
if (!$CI->db->table_exists(db_prefix() . 'as_periodo_laboral')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_periodo_laboral` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `data_inicial` time,
      `data_final` time,
      `intervalo` varchar(200) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }
  if (!$CI->db->table_exists(db_prefix() . 'as_periodo_laboral_func')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_periodo_laboral_func` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `periodo_id` int(11) NOT NULL,
      `func_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }

  if (!$CI->db->table_exists(db_prefix() . 'as_feriados')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_feriados` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `data_inicial` date,
      `data_final` date,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }

  if (!$CI->db->table_exists(db_prefix() . 'as_biometricos')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_biometricos` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `codigo` varchar(200),
      `ip` varchar(200),
      `porta` varchar(200),
      `local` varchar(500),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }
  
  if (!$CI->db->table_exists(db_prefix() . 'as_marcacoes')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_marcacoes` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `dep_id` int(11) NOT NULL,
      `fun_id` int(11) NOT NULL,
      `data` date NOT NULL,
      `horas_trabalhadas` varchar(20),
      `horas_extras` varchar(20),
      `created_at` datetime,
      `modified_at` datetime,
      `created_by`  int(11),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }

  if (!$CI->db->table_exists(db_prefix() . 'as_marcacoes_in_out')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_marcacoes_in_out` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `marc_id` int(11) NOT NULL,
      `marc_in` time,
      `marc_out` time,
      `created_at` datetime,
      `modified_at` datetime,
      `created_by`  int(11),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }

  if (!$CI->db->table_exists(db_prefix() . 'as_frequencias_turnos')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_frequencias_turnos` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `freq` varchar(20) NOT NULL,
      `created_at` datetime,
      `modified_at` datetime,
      `created_by`  int(11),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }// trabalha de quantos dias para quantos dias
  
  if (!$CI->db->table_exists(db_prefix() . 'as_turnos')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_turnos` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `freq_id` int(11) NOT NULL,
      `dias_trabalho` varchar(500) NOT NULL,
      `periodo_id` int(11) NOT NULL,
      `created_at` datetime,
      `modified_at` datetime,
      `created_by`  int(11),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }// os turnos

  if (!$CI->db->table_exists(db_prefix() . 'as_intervalos_turnos')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_intervalos_turnos` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` varchar(200) NOT NULL,
      `marc_in` datetime,
      `marc_out` datetime,
      `created_at` datetime,
      `modified_at` datetime,
      `created_by`  int(11),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }// intervalos de trabalho para os turnos

  if (!$CI->db->table_exists(db_prefix() . 'as_turno_func')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_turno_func` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `turno_id` int(11) NOT NULL,
      `func_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }
  if (!$CI->db->field_exists('turnos_id' ,db_prefix() . 'staff')) { 
    $CI->db->query('ALTER TABLE `' . db_prefix() . "staff`
      ADD COLUMN `turnos_id` INT(11) NOT NULL;");
  }

  if (!$CI->db->table_exists(db_prefix() . 'as_ferias')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_ferias` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `descricao` varchar(4000) NOT NULL,
      `func_id` int(11) NOT NULL,
      `dep_id` int(11) NOT NULL,
      `funcao_id` int(11),
      `estado` varchar(10),
      `de` date NOT NULL,
      `ate` date NOT NULL,
      `data` date NOT NULL,
      `data_inicio` date,
      `n_dias` varchar(10),
      `dias_usados` varchar(10),
      `ano_fiscal` varchar(10),
      `motivo` varchar(4000),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }

  if (!$CI->db->table_exists(db_prefix() . 'as_conf_ferias')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "as_conf_ferias` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `limite_dias_ferias` varchar(10) NOT NULL,
      `n_func_em_ferias` varchar(10) NOT NULL,
      `email_notificacao_inicio` varchar(4000),
      `email_notificacao_termino` varchar(4000),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
  }