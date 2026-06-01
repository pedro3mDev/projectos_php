<?php
    // Status
    $route['api/admin/mod6/gestao_viagem/status/todos'] = 'admin/gestao_viagem/status/index';
    $route['api/admin/mod6/gestao_viagem/status/statu/(:num)'] = 'admin/gestao_viagem/status/show/$1';
    $route['api/admin/mod6/gestao_viagem/status/cadastrar'] = 'admin/gestao_viagem/status/create';
    $route['api/admin/mod6/gestao_viagem/status/actualizar/(:num)'] = 'admin/gestao_viagem/status/update/$1';
    $route['api/admin/mod6/gestao_viagem/status/eliminar/(:num)'] = 'admin/gestao_viagem/status/delete/$1';

    // Pedidos
    $route['api/admin/mod6/gestao_viagem/pedidos/total/(:any)'] = 'admin/gestao_viagem/pedidos/total/$1';
    $route['api/admin/mod6/gestao_viagem/pedidos/total'] = 'admin/gestao_viagem/pedidos/total';
    $route['api/admin/mod6/gestao_viagem/pedidos/todos'] = 'admin/gestao_viagem/pedidos/index';
    $route['api/admin/mod6/gestao_viagem/pedidos/pedido/(:num)'] = 'admin/gestao_viagem/pedidos/show/$1';
    $route['api/admin/mod6/gestao_viagem/pedidos/cadastrar'] = 'admin/gestao_viagem/pedidos/create';
    $route['api/admin/mod6/gestao_viagem/pedidos/actualizar/(:num)'] = 'admin/gestao_viagem/pedidos/update/$1';
    $route['api/admin/mod6/gestao_viagem/pedidos/eliminar/(:num)'] = 'admin/gestao_viagem/pedidos/delete/$1';

    $route['api/admin/mod6/gestao_viagem/equipa/total/(:num)'] = 'admin/gestao_viagem/equipa/total/$1';
    $route['api/admin/mod6/gestao_viagem/equipa/todos/(:num)'] = 'admin/gestao_viagem/equipa/index/$1';
    $route['api/admin/mod6/gestao_viagem/equipa/membro/(:num)/(:num)'] = 'admin/gestao_viagem/equipa/show/$1/$2';
    $route['api/admin/mod6/gestao_viagem/equipa/cadastrar/(:num)'] = 'admin/gestao_viagem/equipa/create/$1';
    $route['api/admin/mod6/gestao_viagem/equipa/eliminar/(:num)/(:num)'] = 'admin/gestao_viagem/equipa/delete/$1/$2';

    // Aprovacao de Viagem
    $route['api/admin/mod6/gestao_viagem/status_pedido/fitlro/(:any)'] = 'admin/gestao_viagem/status_pedido/status/$1';
    $route['api/admin/mod6/gestao_viagem/status_pedido/fitlro_total/(:any)'] = 'admin/gestao_viagem/status_pedido/fitlro_total/$1';
    $route['api/admin/mod6/gestao_viagem/status_pedido/decisao'] = 'admin/gestao_viagem/status_pedido/decisao';
    $route['api/admin/mod6/gestao_viagem/status_pedido/decisao/(:num)'] = 'admin/gestao_viagem/status_pedido/update/$1';
    $route['api/admin/mod6/gestao_viagem/status_pedido/eliminar/(:num)'] = 'admin/gestao_viagem/status_pedido/delete/$1';

    $route['api/admin/mod6/gestao_viagem/reserva_voo/todos/(:num)'] = 'admin/gestao_viagem/reserva_voo/index/$1';
    $route['api/admin/mod6/gestao_viagem/reserva_voo/reserva/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_voo/show/$1/$2';
    $route['api/admin/mod6/gestao_viagem/reserva_voo/cadastrar/(:num)'] = 'admin/gestao_viagem/reserva_voo/create/$1';
    $route['api/admin/mod6/gestao_viagem/reserva_voo/actualizar/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_voo/update/$1/$2';
    $route['api/admin/mod6/gestao_viagem/reserva_voo/eliminar/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_voo/delete/$1/$2';

    $route['api/admin/mod6/gestao_viagem/reserva_hotel/todos/(:num)'] = 'admin/gestao_viagem/reserva_hotel/index/$1';
    $route['api/admin/mod6/gestao_viagem/reserva_hotel/reserva/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_hotel/show/$1/$2';
    $route['api/admin/mod6/gestao_viagem/reserva_hotel/cadastrar/(:num)'] = 'admin/gestao_viagem/reserva_hotel/create/$1';
    $route['api/admin/mod6/gestao_viagem/reserva_hotel/actualizar/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_hotel/update/$1/$2';
    $route['api/admin/mod6/gestao_viagem/reserva_hotel/eliminar/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_hotel/delete/$1/$2';

    $route['api/admin/mod6/gestao_viagem/reserva_transporte/todos/(:num)'] = 'admin/gestao_viagem/reserva_transporte/index/$1';
    $route['api/admin/mod6/gestao_viagem/reserva_transporte/reserva/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_transporte/show/$1/$2';
    $route['api/admin/mod6/gestao_viagem/reserva_transporte/cadastrar/(:num)'] = 'admin/gestao_viagem/reserva_transporte/create/$1';
    $route['api/admin/mod6/gestao_viagem/reserva_transporte/actualizar/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_transporte/update/$1/$2';
    $route['api/admin/mod6/gestao_viagem/reserva_transporte/eliminar/(:num)/(:num)'] = 'admin/gestao_viagem/reserva_transporte/delete/$1/$2';

    // Orçamento
    $route['api/admin/mod6/gestao_viagem/orcamento/todos'] = 'admin/gestao_viagem/orcamento/index';
    $route['api/admin/mod6/gestao_viagem/orcamento/pedido/(:num)'] = 'admin/gestao_viagem/orcamento/show/$1';
    $route['api/admin/mod6/gestao_viagem/orcamento/cadastrar/(:num)'] = 'admin/gestao_viagem/orcamento/create/$1';
    $route['api/admin/mod6/gestao_viagem/orcamento/actualizar/(:num)'] = 'admin/gestao_viagem/orcamento/update/$1';
    $route['api/admin/mod6/gestao_viagem/orcamento/eliminar/(:num)'] = 'admin/gestao_viagem/orcamento/delete/$1';
    // Filtro
    $route['api/admin/mod6/gestao_viagem/orcamento/geral/(:num)'] = 'admin/gestao_viagem/orcamento/geral/$1';

    // Reembolso
    $route['api/admin/mod6/gestao_viagem/reembolso/todos'] = 'admin/gestao_viagem/reembolso/index';
    $route['api/admin/mod6/gestao_viagem/reembolso/orcamento/(:num)'] = 'admin/gestao_viagem/reembolso/show/$1';
    $route['api/admin/mod6/gestao_viagem/reembolso/cadastrar/(:num)'] = 'admin/gestao_viagem/reembolso/create/$1';
    $route['api/admin/mod6/gestao_viagem/reembolso/actualizar/(:num)'] = 'admin/gestao_viagem/reembolso/update/$1';
    $route['api/admin/mod6/gestao_viagem/reembolso/eliminar/(:num)'] = 'admin/gestao_viagem/reembolso/delete/$1';