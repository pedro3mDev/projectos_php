<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'gets_status')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "gets_status` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `status` varchar(200) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (gets_status_exists('Pendente') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gets_status` (`status`) VALUES ("Pendente");
    ');
}
if (gets_status_exists('Aprovado') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gets_status` (`status`) VALUES ("Aprovado");
    ');
}
if (gets_status_exists('Rejeitado') == 0){
    $CI->db->query('INSERT INTO `'.db_prefix().'gets_status` (`status`) VALUES ("Rejeitado");
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_pesquisa_engajamento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_pesquisa_engajamento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            status_id int(11) UNSIGNED NOT NULL,
            titulo varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            data_criacao date NOT NULL,
            data_fim date NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gets_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_pergunta_engajamento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_pergunta_engajamento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            pesquisa_engajamento_id int(11) UNSIGNED NOT NULL,
            texto TEXT NOT NULL,
            tipo_resposta varchar(255) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (pesquisa_engajamento_id) REFERENCES ' . db_prefix() . 'gets_pesquisa_engajamento(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_resposta_engajamento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_resposta_engajamento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            pergunta_engajamento_id int(11) UNSIGNED NOT NULL,
            staff_id int(11) NOT NULL,
            resposta TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (pergunta_engajamento_id) REFERENCES ' . db_prefix() . 'gets_pergunta_engajamento(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if ($CI->db->field_exists('resposta' ,db_prefix() . 'gets_resposta_engajamento')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . "gets_resposta_engajamento`
      CHANGE COLUMN `resposta` `resposta` int(11) NOT NULL
    ;");
  }

if (!$CI->db->table_exists(db_prefix() . 'gets_reconhecimento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_reconhecimento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            staff_id int(11) NOT NULL,
            tipo varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            data_reconhecimento date NOT NULL,
            pontos int(11) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_premio')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_premio (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            nome varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            pontos_necessario int(11) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_resgate_premio')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_resgate_premio (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            staff_id int(11) NOT NULL,
            premio_id int(11) UNSIGNED NOT NULL,
            data_resgate date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (premio_id) REFERENCES ' . db_prefix() . 'gets_premio(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_comunicacao_interna')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_comunicacao_interna (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            autor_id int(11) NOT NULL,
            titulo varchar(255) NOT NULL,
            mensagem TEXT NOT NULL,
            data_publicacao date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (autor_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

// Feedback Continuo
if (!$CI->db->table_exists(db_prefix() . 'gets_feedback_continuo')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_feedback_continuo (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            remetente_id int(11) NOT NULL,
            destinatario_id int(11) NOT NULL,
            mensagem TEXT NOT NULL,
            data_criacao timestamp NOT NULL DEFAULT current_timestamp(),
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (remetente_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (destinatario_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

// GrupoColaboracao
if (!$CI->db->table_exists(db_prefix() . 'gets_grupo_colaboracao')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_grupo_colaboracao (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            criador_id int(11) NOT NULL,
            nome varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            data_criacao timestamp NOT NULL DEFAULT current_timestamp(),
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (criador_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

// Evento
if (!$CI->db->table_exists(db_prefix() . 'gets_evento')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_evento (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            organizador_id int(11) NOT NULL,
            titulo varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            local TEXT NOT NULL,
            data_evento date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (organizador_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_pesquisa_clima')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_pesquisa_clima (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            status_id int(11) UNSIGNED NOT NULL,
            titulo varchar(255) NOT NULL,
            descricao TEXT NOT NULL,
            data_criacao date NOT NULL,
            aprovadores TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (status_id) REFERENCES ' . db_prefix() . 'gets_status(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gets_pergunta_clima')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_pergunta_clima (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            pesquisa_clima_id int(11) UNSIGNED NOT NULL,
            texto TEXT NOT NULL,
            tipo_resposta varchar(255) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (pesquisa_clima_id) REFERENCES ' . db_prefix() . 'gets_pesquisa_clima(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}
if (!$CI->db->table_exists(db_prefix() . 'gets_resposta_clima')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_resposta_clima (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            pergunta_clima_id int(11) UNSIGNED NOT NULL,
            staff_id int(11) NOT NULL,
            resposta TEXT NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (pergunta_clima_id) REFERENCES ' . db_prefix() . 'gets_pergunta_clima(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_conflito')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_conflito (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            staff_id int(11) NOT NULL,
            descricao TEXT NOT NULL,
            status enum("em_andamento","nao_resolvido","resolvido") NOT NULL,
            data_registro date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (staff_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'gets_medicao_conflito')) {
    $CI->db->query('
        CREATE TABLE ' . db_prefix() . 'gets_medicao_conflito (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            mediador_id int(11) NOT NULL,
            conflito_id int(11) UNSIGNED NOT NULL,
            descricao TEXT NOT NULL,
            status enum("em_andamento","nao_resolvido","resolvido") NOT NULL,
            data_mediacao date NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            FOREIGN KEY (mediador_id) REFERENCES ' . db_prefix() . 'staff(staffid) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (conflito_id) REFERENCES ' . db_prefix() . 'gets_conflito(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ');
}