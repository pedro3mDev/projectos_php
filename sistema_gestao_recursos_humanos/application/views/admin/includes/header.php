<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="content" style=" position:fixed; top:0px; left:0; width: 100%; z-index: 1000; padding: 0px;">
    
    <div id="header" style=" background: linear-gradient(to right, #fff, #fff);">

        <button type="button"
            class="hide-menu tw-inline-flex tw-bg-transparent tw-border-0 tw-p-1 tw-mt-4 hover:tw-bg-neutral-600/10 tw-text-neutral-600 hover:tw-text-neutral-800 focus:tw-text-neutral-800 focus:tw-outline-none tw-rounded-md tw-mx-4 ltr:md:tw-ml-4 rtl:md:tw-mr-4 ltr:tw-float-left  rtl:tw-float-right">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="tw-h-4 tw-w-4 tw-text-current">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.003h19.5m-19.5-6h19.5m-19.5-6h19.5"></path>
            </svg>
        </button>

        <nav>
            <div class="tw-flex tw-justify-between">
                <div class="tw-overflow-hidden tw-shrink-0">
                    <div id="logo"
                        class="tw-h-[57px] tw-hidden md:tw-flex tw-items-center [&_img]:tw-h-9 [&_img]:tw-w-auto">
                        <?php $logo = get_admin_header_logo_url(); ?>
                        <?php if (! $logo) { ?>
                            <a class="logo logo-text tw-text-2xl tw-font-semibold" href="<?= hooks()->apply_filters('admin_header_logo_href', admin_url()); ?>">
                                <?= e(get_option('companyname')); ?>
                            </a>
                        <?php } else { ?>
                            <a class="logo" href="<?= hooks()->apply_filters('admin_header_logo_href', admin_url()); ?>">
                                <img src="<?= e($logo); ?>" class="img-responsive" alt="<?= e(get_option('companyname')); ?>" />
                            </a>
                        <?php } ?>
                    </div>
                    
                    
                </div>
            
                <div class="mobile-menu tw-shrink-0 ltr:tw-ml-4 rtl:tw-mr-4">
                    <button style="background-color: #fff;" type="button" class="navbar-toggle visible-md visible-sm visible-xs mobile-menu-toggle collapsed tw-ml-1.5 tw-text-neutral-600 hover:tw-text-neutral-800" data-toggle="collapse" data-target="#mobile-collapse" aria-expanded="false">
                        <i class="fa fa-chevron-down fa-lg"></i>                
                    </button>
                    <ul class="mobile-icon-menu tw-inline-flex tw-mt-5">
                        <?php
                            // To prevent not loading the timers twice
                            if (is_mobile()) { ?>
                                <li class="dropdown notifications-wrapper header-notifications tw-block ltr:tw-mr-3 rtl:tw-ml-3">
                                    <?php $this->load->view('admin/includes/notifications'); ?>
                                </li>
                                <li class="header-timers ltr:tw-mr-1.5 rtl:tw-ml-1.5">
                                    <a href="#" id="top-timers" class="dropdown-toggle top-timers tw-block tw-h-5 tw-w-5" data-toggle="dropdown">
                                        <i class="fa-regular fa-clock fa-lg tw-text-neutral-400 group-hover:tw-text-neutral-800 tw-shrink-0<?= count($startedTimers) > 0 ? ' tw-animate-spin-slow' : ''; ?>"></i>
                                        <span class="tw-leading-none tw-px-1 tw-py-0.5 tw-text-xs bg-success tw-z-10 tw-absolute tw-rounded-full -tw-right-3 -tw-top-2 tw-min-w-[18px] tw-min-h-[18px] tw-inline-flex tw-items-center tw-justify-center icon-started-timers<?= $totalTimers = count($startedTimers) == 0 ? ' hide' : ''; ?>"><?= count($startedTimers); ?></span>
                                    </a>
                                    <ul class="dropdown-menu animated fadeIn started-timers-top width300" id="started-timers-top">
                                        <?php $this->load->view('admin/tasks/started_timers', ['startedTimers' => $startedTimers]); ?>
                                    </ul>
                                </li>
                            <?php } ?>
                    </ul>
                    <div class="mobile-navbar collapse" id="mobile-collapse" aria-expanded="false" style="height: 0px;" role="navigation">
                        <ul class="nav navbar-nav">
                            <li class="header-my-profile" >
                                <a href="<?= admin_url('profile'); ?>" >
                                    <?= _l('nav_my_profile'); ?> 
                                </a>
                            </li>
                            <li class="header-my-timesheets">
                                <a href="<?= admin_url('staff/timesheets'); ?>">
                                    <?= _l('my_timesheets'); ?>
                                </a>
                            </li>
                            <li class="header-edit-profile">
                                <a href="<?= admin_url('staff/edit_profile'); ?>">
                                    <?= _l('nav_edit_profile'); ?>
                                </a>
                            </li>
                            <?php if (is_staff_member()) { ?>
                            <li class="header-newsfeed">
                                <a href="#" class="open_newsfeed mobile">
                                    <?= _l('whats_on_your_mind'); ?>
                                </a>
                            </li>
                            <?php } ?>
                            <li class="header-logout">
                                <a href="#" onclick="logout(); return false;">
                                    <?= _l('nav_logout'); ?>
                                </a>
                            </li>
                        </ul>
                        
                    </div>
                </div> 
                
                <ul class="nav navbar-nav navbar-right -tw-mt-px" >
                
                <?php hooks()->do_action('admin_navbar_start'); ?> 
                <?php if (staff_can('view', 'settings')) { ?>
            <!--li>
                <a style="color:#DAA520;" href="<?= admin_url('settings'); ?>">
                    <span class="tw-flex tw-items-center tw-gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span><?= _l('settings'); ?></span>
                    </span>
                </a>
            </li-->
            <?php } ?>

            <?php if (!is_language_disabled()) { ?>
            <li class="dropdown-submenu pull-left header-languages">
                <a href="#" style="color:#336;" tabindex="-1">
                    <i class="fa fa-globe"></i> <?= _l('language'); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu">
                    <li class="<?= $current_user->default_language == '' ? 'active' : ''; ?>">
                        <a href="<?= admin_url('staff/change_language'); ?>">
                            <?= _l('system_default_string'); ?>
                        </a>
                    </li>
                    <?php foreach ($this->app->get_available_languages() as $user_lang) { ?>
                        <li class="<?= $current_user->default_language == $user_lang ? 'active' : ''; ?>">
                            <a href="<?= admin_url('staff/change_language/' . $user_lang); ?>">
                                <?= e(ucfirst($user_lang)); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
                <?php if (is_staff_member()) { ?>
                <li class="icon header-newsfeed -tw-mr-1.5">
                    <a style="color:#8B0000;" href="#" class="open_newsfeed desktop" data-toggle="tooltip"
                        title="<?= _l('whats_on_your_mind'); ?>"
                        data-placement="bottom">
                        <span class="tw-flex tw-items-center tw-gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor"
                                class="tw-w-[calc(theme(spacing.5)-1px)] tw-h-[calc(theme(spacing.5)-1px)]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                            </svg>
                            <span><?= _l('Partilhar'); ?></span>
                        </span>
                    </a>
                </li>
                <?php } ?>

                <li class="icon header-todo">
                    <a style="color:#008B8B;" href="<?= admin_url('todo'); ?>" 
                        class="open_newsfeed desktop" data-toggle="tooltip" 
                        title="<?= _l('nav_todo_items'); ?>" 
                        data-placement="bottom">
                        <span class="tw-flex tw-items-center tw-gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                    stroke-width="1.5" stroke="currentColor" 
                                    class="tw-w-[calc(theme(spacing.5)-1px)] tw-h-[calc(theme(spacing.5)-1px)]">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M3 5.25h6m-6 4.5h6m-6 4.5h6m-6 4.5h6M12 5.25h9M12 9.75h9m-9 4.5h9m-9 4.5h9" />
                            </svg>
                            <span><?= _l('Todo'); ?></span>
                        </span>
                    </a>
                </li> 

                <li style="color:#006400;" class="icon header-timers timer-button tw-relative ltr:tw-mr-1.5 rtl:tw-ml-1.5"
                    data-placement="bottom" data-toggle="tooltip" 
                    data-title="<?= _l('my_timesheets'); ?>">
                    <a style="color:#006400;" href="#" id="top-timers" 
                    class="top-timers !tw-px-0 tw-group" data-toggle="dropdown">
                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-8 tw-w-9 -tw-mt-1.5">
                            <i style="color:#006400;" class="fa-regular fa-clock fa-lg tw-text-neutral-400 group-hover:tw-text-neutral-800 tw-shrink-0<?= count($startedTimers) > 0 ? ' tw-animate-spin-slow' : ''; ?>"></i>
                        </span>
                        <span class="tw-text-sm tw-font-medium tw-ml-2">Cronometro</span>
                        <span
                            class="tw-leading-none tw-px-1 tw-py-0.5 tw-text-xs bg-success tw-z-10 tw-absolute tw-rounded-full -tw-right-1.5 tw-top-2 tw-min-w-[18px] tw-min-h-[18px] tw-inline-flex tw-items-center tw-justify-center icon-started-timers<?= $totalTimers = count($startedTimers) == 0 ? ' hide' : ''; ?>">
                            <?= count($startedTimers); ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeIn started-timers-top width300" id="started-timers-top">
                        <?php $this->load->view('admin/tasks/started_timers', ['startedTimers' => $startedTimers]); ?>
                    </ul>
                </li>


                <li class="icon dropdown tw-relative tw-block notifications-wrapper header-notifications rtl:tw-ml-3"
                    data-toggle="tooltip"
                    title="<?= _l('nav_notifications'); ?>"
                    data-placement="bottom">
                    <?php $this->load->view('admin/includes/notifications'); ?>
                </li>

                <?php hooks()->do_action('admin_navbar_end'); ?>
            </ul>
            
            </div>
        </nav>
        
    </div> 
    
    <div class="content row" style="position: relative; overflow: hidden; border-radius: 0px; border-bottom: 1px solid red; background-color: #336; padding: 10px;">
        <button onclick="slide(-1)" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: #800000; border:1px solid #fff;  color: #fff; border-radius: 20px; font-size: 14px; padding: 5px 10px; border: none; cursor: pointer; z-index: 10;">
            &#8249;
        </button>
        <ul id="carousel-list" style="list-style: none; padding: 0; margin: 0; display: inline-flex; gap: 20px; align-items: center; white-space: nowrap; transition: transform 0.5s;">
            <li class="carousel-item">
                <a href="" style="text-decoration: none; color: inherit;"></a>
            </li>
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('recruitment/dashboard'),
                admin_url('recruitment/recruitment_proposal'),
                admin_url('recruitment/recruitment_campaign'),
                admin_url('recruitment/candidate_profile'), 
                admin_url('recruitment/triagem_geral'),
                admin_url('recruitment/interview_schedule'),
                admin_url('recruitment/recruitment_channel'),
                admin_url('recruitment/setting')
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('recruitment/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-user-tie"></i> Recrutamento
                </a> 
            </li>
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('hr_profile/dashboard'),
                admin_url('hr_profile/staff_infor'),
                admin_url('hr_profile/job_positions'),
                admin_url('hr_profile/reception_staff'),
                admin_url('hr_profile/training?group=training_program'),
                admin_url('hr_profile/contracts'),
                admin_url('hr_profile/setting?group=contract_type'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('hr_profile/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-handshake"></i> Integração
                </a>
            </li>
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('document_management/dashboard'),
                admin_url('document_management'),
                admin_url('document_management/settings?tab=custom_field'),
                admin_url('document_management/seccoes'),
                admin_url('document_management/pastas'),
                admin_url('document_management/?share_to_me=1&id=0'),
                admin_url('document_management?my_approval=1&id=0'),
                admin_url('document_management?electronic_signing=1&id=0'),
                admin_url(''), 
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('document_management/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-folder"></i> Documentos
                </a>
            </li>
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('gestao_assiduidade/dashboard'),
                admin_url('gestao_assiduidade/configuracoes?group=periodo_laboral'),
                admin_url('gestao_assiduidade/relatorios'),
                admin_url('gestao_assiduidade/horario_turno'),
                admin_url('gestao_assiduidade/gestao_de_ferias'),
                admin_url('gestao_assiduidade/index'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('gestao_assiduidade/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-calendar-check"></i> Assiduidade
                </a>
            </li>
 
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('approvify/'),
                admin_url('approvify/manage_requests'),
                admin_url('approvify/manage_created_requests'),
                admin_url('approvify/manage_review_requests'),
                admin_url('approvify/configuracoes'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('approvify/'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-file-alt"></i> Requisições
                </a>
            </li>

            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('gestao_viagens/index'),
                admin_url('gestao_viagens/pedidos'),
                admin_url('gestao_viagens/pedidos/reservas'),
                admin_url('gestao_viagens/orcamentos'),
                admin_url('gestao_viagens/despesas'),
                admin_url('gestao_viagens/comunicacao'),
                admin_url('gestao_viagens/feedback'),
                admin_url('gestao_viagens/configuracoes'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('gestao_viagens/index'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-plane"></i> Viagens
                </a>
            </li>

            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('politicas_empresa/'),
                admin_url('politicas_empresa/listagem'), 
                admin_url('politicas_empresa/revisoes'),
                admin_url('politicas_empresa/conformidades'),
                admin_url('politicas_empresa/riscos'),
                admin_url('politicas_empresa/procedimentos'),
                admin_url('politicas_empresa/comunicacoes'),
                admin_url('politicas_empresa/processos'),
                admin_url('politicas_empresa/configuracoes'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('politicas_empresa/'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-cogs"></i> Políticas
                </a>
            </li>
            
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('gestao_formacao/dashboard'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('gestao_formacao/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-chalkboard-teacher"></i> Formação
                </a>
            </li>
 
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('gestao_desenv_individual/dashboard'),
                admin_url('gestao_desenv_individual/planos'),
                admin_url('gestao_desenv_individual/avaliacoes'),
                admin_url('gestao_desenv_individual/mentoria'),
                admin_url('gestao_desenv_individual/carreira'),
                admin_url('gestao_desenv_individual/configuracoes'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('gestao_desenv_individual/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-user"></i> DI
                </a>
            </li>
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('plan_sucess_lideranca/dashboard'),
                admin_url('plan_sucess_lideranca/identificacao'),
                admin_url('plan_sucess_lideranca/planeamento'),
                admin_url('plan_sucess_lideranca/desenvolvimento'), 
                admin_url('plan_sucess_lideranca/competencias'),
                admin_url('plan_sucess_lideranca/mentoria_coaching'),
                admin_url('plan_sucess_lideranca/analise_risco'),
                admin_url('plan_sucess_lideranca/engajamento'),
                admin_url('plan_sucess_lideranca/identificacao_resultado'),
                admin_url('plan_sucess_lideranca/planeamento_resultado'),
                admin_url('plan_sucess_lideranca/desenvolvimento_resultado'),
                admin_url('plan_sucess_lideranca/engajamento_resultado'),
                admin_url('plan_sucess_lideranca/analise_risco_resultado'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('plan_sucess_lideranca/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-trophy"></i> Sucessão e Liderança
                </a>
            </li>  

            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('gestao_remuneracao/dashboard'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('gestao_remuneracao/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-dollar-sign"></i> Remuneração
                </a>
            </li> 

            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('gestao_engajamento_talentos/dashboard'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('gestao_engajamento_talentos/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-users"></i> Engajamento Talentos
                </a>
            </li>

            <li class="carousel-item <?= in_array(current_url(), [
                            admin_url('plan_forca_trabalho/dashboard'),
                        ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('plan_forca_trabalho/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-briefcase"></i> Força Trabalho
                </a>
            </li>

            <!--li class="carousel-item <?= in_array(current_url(), [
                            admin_url('relatorios/dashboard'),
                        ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('relatorios/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-chart-line"></i> Relatórios
                </a> 
            </li-->

            
            <li class="carousel-item <?= in_array(current_url(), [
                admin_url('configuracoes/'),
                admin_url('seetings/'),
                admin_url('configuracoes/sistema'),
                admin_url('modules'),
            ]) ? 'active' : '' ?>">
                <a href="<?= admin_url('configuracoes/'); ?>" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-cogs"></i> Configurações 
                </a>
            </li>

            
        </ul>
        

        <button onclick="slide(1)" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: #800000; color: #fff; border-radius: 20px; font-size: 14px; padding: 5px 10px; border: none; cursor: pointer; z-index: 10;">
            &#8250;
        </button>
    </div>

        
    <script>
        let currentIndex = 0; // Índice do slide atual

        function slide(direction) {
            const carousel = document.getElementById("carousel-list"); // ID correto
            const slides = carousel.children;
            const totalSlides = slides.length;
            const slideWidth = slides[0].offsetWidth + 20; // Inclui o gap de 20px entre os slides

            // Atualizar índice do slide
            currentIndex += direction;

            // Certificar-se de que o índice está dentro dos limites
            if (currentIndex < 0) {
                currentIndex = totalSlides - 1; // Voltar ao último slide
            } else if (currentIndex >= totalSlides) {
                currentIndex = 0; // Voltar ao primeiro slide
            }

            // Mover o carrossel
            carousel.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            carousel.style.transition = "transform 0.5s ease-in-out";
        }
    </script>



    <style>
        .carousel-item {
            color: #fff;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
            cursor: pointer;
            white-space: nowrap;
        }

        .carousel-item i {
            color: #fff;
            margin-right: 10px;
            transition: color 0.3s, transform 0.3s;
        }

        .carousel-item:hover {
            color: #DAA520;
            transform: scale(1.05);
        }

        .carousel-item:hover i {
            color: #DAA520;
            transform: scale(1.2);
        }
        .carousel-item.active {
            background-color: #DAA520;
            color: #fff;
        }

        .carousel-item.active i {
            color: #fff;
        }

    </style>

</div> 
