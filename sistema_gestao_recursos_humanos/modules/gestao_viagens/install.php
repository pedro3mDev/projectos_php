<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'gv_status')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status` varchar(200) NOT NULL,
      `descricao` TEXT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_tipo_viagem')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_tipo_viagem` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tipo_viagem` varchar(200) NOT NULL,
    `descricao` TEXT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (gv_tipo_viagem_exists(1) == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'gv_tipo_viagem` (`tipo_viagem`,`descricao`) VALUES ("Férias","");
  ');
}
else {
  $CI->db->query('UPDATE `'.db_prefix().'gv_tipo_viagem` SET `tipo_viagem` = "Férias" WHERE `id` = 1;');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_classificacoes')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_classificacoes` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `descricao` TEXT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_reletorio_feedback')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_reletorio_feedback` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `classificacao_id` int(11) NOT NULL,
      `orcamento_viagem_id` int(11) NOT NULL,
      `feedback` text NOT NULL,
      `data_feedback` date NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_categoria')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_categoria` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria` varchar(200) NOT NULL,
    `descricao` TEXT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_pedido_viagem')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_pedido_viagem` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `tipo_viagem_id` int(11) NOT NULL,
        `status_id` int(11) NOT NULL,
        `categoria_id` int(11) NOT NULL,
        `objetivo` text NOT NULL,
        `destino` varchar(255) NOT NULL,
        `data_inicio` date NOT NULL,
        `data_fim` date NOT NULL,
        `aprovadores` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_staff_viagem')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_staff_viagem` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `pedido_viagem_id` int(11) NOT NULL,
        `staff_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gv_hotel')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_hotel` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status_id` int(11) NOT NULL,
      `nome` varchar(255) NOT NULL,
      `descricao` text NOT NULL,
      `endereco` text NOT NULL,
      `data_checkin` date NOT NULL,
      `data_checkout` date NOT NULL,
      `preco` decimal(10,2) NOT NULL,
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_voo')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_voo` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status_id` int(11) NOT NULL,
      `nome` varchar(255) NOT NULL,
      `descricao` text NOT NULL,
      `local_partida` varchar(255) NOT NULL,
      `local_destino` varchar(255) NOT NULL,
      `data_partida` date NOT NULL,
      `preco` decimal(10,2) NOT NULL,
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_transporte')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_transporte` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status_id` int(11) NOT NULL,
      `nome` varchar(255) NOT NULL,
      `descricao` text NOT NULL,
      `preco` decimal(10,2) NOT NULL,
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_reserva')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_reserva` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `pedido_viagem_id` int(11) NOT NULL,
      `status_id` int(11) NOT NULL,
      `voo_id` int(11) NOT NULL,
      `hotel_id` int(11) NOT NULL,
      `transporte_id` int(11) NOT NULL,
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('arquivo_visto' ,db_prefix() . 'gv_reserva')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . "gv_reserva`
    ADD COLUMN `arquivo_visto` VARCHAR(255) NULL DEFAULT NULL
  ;");
}
if (!$CI->db->table_exists(db_prefix() . 'gv_estimativa_viagem')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_estimativa_viagem` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `tipo_viagem_id` int(11) NOT NULL,
      `valor` decimal(10,2) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gv_orcamento_viagem')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_orcamento_viagem` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status_id` int(11) NOT NULL,
      `reserva_id` int(11) NOT NULL,
      `estimativa_viagem_id` int(11) NULL,
      `aprovadores` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_categoria_despesa')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_categoria_despesa` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria` varchar(200) NOT NULL,
    `descricao` TEXT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_despesas')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_despesas` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria_despesa_id` int(11) NOT NULL,
    `orcamento_viagem_id` int(11) NOT NULL,
    `status_id` int(11) NOT NULL,
    `arquivo` varchar(255) NOT NULL,
    `descricao` TEXT NULL,
    `valor` decimal(10,2) NOT NULL,
    `data_despesa` date NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'gv_tipo_comunicacao')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_tipo_comunicacao` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `descricao` TEXT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_comunicacao_viagem')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_comunicacao_viagem` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tipo_comunicacao_id` int(11) NOT NULL,
    `orcamento_viagem_id` int(11) NOT NULL,
    `arquivo` varchar(255) NOT NULL,
    `mensagem` TEXT NULL,
    `data_envio` date NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'gv_staff_comunicacao')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_staff_comunicacao` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `comunicacao_viagem_id` int(11) NOT NULL,
      `staff_id` int(11) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

// if (!$CI->db->table_exists(db_prefix() . 'gv_categoria')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_categoria` (
//     `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//     `categoria` varchar(200) NOT NULL,
//     `descricao` TEXT NULL,
//     `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//     `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }


// if (gv_status_exists('"pendente"') == 0){
//     $CI->db->query('INSERT INTO `'.db_prefix().'gv_status` (`status`) VALUES ("pendente");
//   ');
// }
// if (gv_status_exists('"aprovado"') == 0){
//     $CI->db->query('INSERT INTO `'.db_prefix().'gv_status` (`status`) VALUES ("aprovado");
//   ');
// }
// if (gv_status_exists('"cancelado"') == 0){
//     $CI->db->query('INSERT INTO `'.db_prefix().'gv_status` (`status`) VALUES ("cancelado");
//   ');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_pedido_viagem')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_pedido_viagem` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `staff_id` int(11) NOT NULL,
//         `tipo_viagem` enum('nacional','internacional') NOT NULL,
//         `objetivo` text NOT NULL,
//         `destino` varchar(255) NOT NULL,
//         `data_inicio` date NOT NULL,
//         `data_fim` date NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_decisao_viagem')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_decisao_viagem` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `decisao` enum('aprovado','rejeitado') NOT NULL,
//         `data` timestamp NOT NULL DEFAULT current_timestamp(),
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_staff_viagem')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_staff_viagem` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `staff_id_viagem` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_orcamento_viagem')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_orcamento_viagem` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `orcamento` decimal(10,0) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'gv_reembolso_viagem')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_reembolso_viagem` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `orcamento_viagem_id` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `reembolso` decimal(10,0) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'gv_reserva_voo')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_reserva_voo` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `status_id` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `descricao` text NOT NULL,
//         `partida` varchar(255) NOT NULL,
//         `destino` varchar(255) NOT NULL,
//         `data_partida` datetime NOT NULL,
//         `preco` decimal(10,0) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'gv_reserva_hotel')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_reserva_hotel` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `status_id` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `hotel` varchar(255) NOT NULL,
//         `data_checkin` datetime NOT NULL,
//         `data_checkout` datetime NOT NULL,
//         `preco` decimal(10,0) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'gv_reserva_transporte')) {
//   $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_reserva_transporte` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `pedido_viagem_id` int(11) NOT NULL,
//       `status_id` int(11) NOT NULL,
//       `staff_id` int(11) NOT NULL,
//       `descricao` text NOT NULL,
//       `tipo_reserva` enum('taxi','car_sharing','rent_a_car','renting','europcar') NOT NULL,
//       `local_partida` varchar(255) DEFAULT NULL,
//       `local_destino` varchar(255) DEFAULT NULL,
//       `preco` decimal(10,0) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_despesa')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_despesa` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `despesa` text NOT NULL,
//         `comprovante` varchar(255) DEFAULT NULL,
//         `preco` decimal(10,0) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_despesa_decisao')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_despesa_decisao` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `despesa_viagem_id` int(11) NOT NULL,
//         `status_id` int(11) NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// Esta tabela deve estar no mudulo que trata sobre as politicas da empresa
// if (!$CI->db->table_exists(db_prefix() . 'pl_politica_empresa')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "pl_politica_empresa` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `staff_id` int(11) NOT NULL,
//         `status_id` int(11) NOT NULL,
//         `titulo` varchar(255) NOT NULL,
//         `descricao` text NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (!$CI->db->table_exists(db_prefix() . 'pl_status')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "pl_status` (
//       `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//       `status` varchar(200) NOT NULL,
//       `descricao` varchar(200) NOT NULL,
//       `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//       `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }
// if (gv_status_exists('"Ativo"') == 0){
//     $CI->db->query('INSERT INTO `'.db_prefix().'pl_status` (`status`,`descricao`) VALUES ("ativo", "Status da Politica ativo");
//   ');
// }
// if (gv_status_exists('"Inativo"') == 0){
//     $CI->db->query('INSERT INTO `'.db_prefix().'pl_status` (`status`,`descricao`) VALUES ("inativo", "Status da Politica inativo");
//   ');
// }
// if (gv_status_exists('"Em revisão"') == 0){
//     $CI->db->query('INSERT INTO `'.db_prefix().'pl_status` (`status`,`descricao`) VALUES ("Em revisão", "Status da Politica Em revisão");
//   ');
// }
// FIM -- Esta tabela deve estar no mudulo que trata sobre as politicas da empresa

// if (!$CI->db->table_exists(db_prefix() . 'gv_politica_viagem')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_politica_viagem` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `politica_viagem` text NOT NULL,
//         `staff_id` int(11) NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }

// if (!$CI->db->table_exists(db_prefix() . 'gv_feedback')) {
//     $CI->db->query('CREATE TABLE `' . db_prefix() . "gv_feedback` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `pedido_viagem_id` int(11) NOT NULL,
//         `staff_id_viagem` int(11) NOT NULL,
//         `feedback` text NOT NULL,
//         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//       PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
// }