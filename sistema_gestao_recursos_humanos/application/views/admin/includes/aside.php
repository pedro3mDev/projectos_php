<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<aside id="menu" class="sidebar" style=" 
        background-color: #336; 
        border-radius: 30px; 
        border-bottom: 1px solid red; 
        position: fixed; 
        top: 130px; /* Distância do topo */
        left: 0;    /* Fixa no lado esquerdo da tela */
        height: calc(100% - 130px); /* Ajusta a altura para ocupar o restante da tela */
        ">
 
    <?php $isSidebarDark = function_exists('is_admin_sidebar_background_light') ? 
        is_admin_sidebar_background_light() : 
        false; ?>
    
    <div class="dropdown sidebar-user-profile tw-mt-[80px] tw-mx-1.5 " >
        <a href="#"
            class="dropdown-toggle profile -tw-mt-1 tw-font-medium tw-rounded-lg tw-bg-white/20 tw-py-2 tw-px-2.5 tw-block <?= $isSidebarDark ? 'tw-text-white tw-border-white/10 hover:tw-border-white/30 focus:tw-border-white/30 hover:tw-text-white focus:tw-text-white hover:tw-bg-neutral-900/10 focus:tw-bg-neutral-900/10' : 'tw-border-neutral-900/20 tw-text-neutral-700 hover:tw-text-neutral-800 focus:tw-text-neutral-800 hover:tw-bg-neutral-900/5 focus:tw-bg-neutral-900/5'; ?>"
            data-toggle="dropdown" aria-expanded="false"
            >
            <span class="tw-inline-flex tw-items-center tw-gap-x-3 tw-pt-0.5">
                <?= staff_profile_image($current_user->staffid, ['img', 'img-responsive', 'staff-profile-image-small']); ?>
                <span>
                    <span class="tw-truncate tw-block tw-w-[140px] tw-font-semibold" style="color:#DAA520;">
                        <?= get_staff_full_name(); ?>
                    </span>
                    <span
                        class="tw-font-normal tw-truncate tw-block tw-w-[140px] tw-text-sm <?= $isSidebarDark ? 'tw-text-neutral-300' : 'tw-text-neutral-500' ?>"
                        style="color:#DAA520;">
                        <?= get_staff()->email; ?>
                    </span>
                </span>
            </span>
        </a>
        <ul class="dropdown-menu tw-w-full" style="background-color:#ccc;">
            <li class="header-my-profile" ><a style="color:#336;"
                    href="<?= admin_url('profile'); ?>"><?= _l('nav_my_profile'); ?></a>
            </li>
            <li class="header-my-timesheets"><a style="color:#336;"
                    href="<?= admin_url('staff/timesheets'); ?>"><?= _l('my_timesheets'); ?></a>
            </li>
            <li class="header-edit-profile"><a style="color:#336;"
                    href="<?= admin_url('staff/edit_profile'); ?>"><?= _l('nav_edit_profile'); ?>
                </a>
            </li>

            <li class="header-logout">
                <a href="#"  style="color:#336;"
                    onclick="logout(); return false;"><?= _l('nav_logout'); ?></a>
            </li>
        </ul>
    </div>
    
    <ul class="nav metis-menu tw-mt-[15px]" id="side-menu">

        <?php
            hooks()->do_action('before_render_aside_menu');
        ?>
        
        <?php foreach ($sidebar_menu as $key => $item) {
            if ((isset($item['collapse']) && $item['collapse']) && count($item['children']) === 0) {
                continue; 
            } 
        ?>

        <li class="menu-item-<?= e($item['slug']); ?>"
            <?= _attributes_to_string($item['li_attributes'] ?? []); ?>>
            <a  style="color:#DAA520;" href="<?= count($item['children']) > 0 ? '#' : $item['href']; ?>"
                aria-expanded="false"
                <?= _attributes_to_string($item['href_attributes'] ?? []); ?>>
                <i
                    class="<?= e($item['icon']); ?> menu-icon" style="color:#FFD700;"></i>
                <span class="menu-text">
                    <?= e(_l($item['name'], '', false)); ?>
                </span>
                <?php if (count($item['children']) > 0) { ?>
                <span class="fa arrow pleft5"></span>
                <?php } ?>
                <?php if (isset($item['badge'], $item['badge']['value']) && ! empty($item['badge'])) {?>
                <span
                    class="badge pull-right
               <?= isset($item['badge']['type']) && $item['badge']['type'] != '' ? "bg-{$item['badge']['type']}" : 'bg-info' ?>"
                    <?= (isset($item['badge']['type']) && $item['badge']['type'] == '')
                       || isset($item['badge']['color']) ? "style='background-color: {$item['badge']['color']}'" : '' ?>>
                    <?= e($item['badge']['value']) ?>
                </span>
                <?php } ?>
            </a>
            <?php if (count($item['children']) > 0) { ?>
            <ul class="nav nav-second-level collapse" aria-expanded="false">
                <?php foreach ($item['children'] as $submenu) { ?>
                <li class="sub-menu-item-<?= e($submenu['slug']); ?>"
                    <?= _attributes_to_string($submenu['li_attributes'] ?? []); ?>>
                    <a style="color:#fff;" href="<?= e($submenu['href']); ?>"
                        <?= _attributes_to_string($submenu['href_attributes'] ?? []); ?>>
                        <?php if (! empty($submenu['icon'])) { ?>
                        <i
                            class="<?= e($submenu['icon']); ?> menu-icon" style="color:#FFD700;"></i>
                        <?php } ?>
                        <span class="sub-menu-text">
                            <?= _l($submenu['name'], '', false); ?>
                        </span>
                    </a>
                    <?php if (isset($submenu['badge'], $submenu['badge']['value']) && ! empty($submenu['badge'])) {?>
                    <span
                        class="badge pull-right
               <?= isset($submenu['badge']['type']) && $submenu['badge']['type'] != '' ? "bg-{$submenu['badge']['type']}" : 'bg-info' ?>"
                        <?= (isset($submenu['badge']['type']) && $submenu['badge']['type'] == '')
               || isset($submenu['badge']['color']) ? "style='background-color: {$submenu['badge']['color']}'" : '' ?>>
                        <?= e($submenu['badge']['value']) ?>
                    </span>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
        </li>
        <?php hooks()->do_action('after_render_single_aside_menu', $item); ?> 
        <?php
        } ?>
        <?php if ($this->app->show_setup_menu() == true && (is_staff_member() || is_admin())) { ?>
        <li<?php if (get_option('show_setup_menu_item_only_on_hover') == 1) {
            echo ' style="display:none;"';
        } ?> id="setup-menu-item">
            
            <?php } ?>
            </li>
            <?php hooks()->do_action('after_render_aside_menu'); ?>
            <?php $this->load->view('admin/projects/pinned'); ?>
    </ul>
    
</aside>
<style>

#menu {
    max-height: 80vh; /* Limita a altura ao máximo de 80% da viewport */
    overflow-y: auto; /* Adiciona rolagem vertical, se necessário */
}

/* Estilo para os itens do menu */
#menu ul.nav > li{
    color: #DAA520;
}
#menu ul.nav > li > a:hover,
#menu ul.nav > li > ul.nav-second-level > li > a:hover {
    background-color: #A52A2A; /* Fundo vermelho ao passar o mouse */
    color: white !important; /* Texto branco ao passar o mouse */
    transition: background-color 0.6s, color 0.9s; /* Transição suave */
}

/* Estilo padrão para os submenus */
#menu ul.nav > li > ul.nav-second-level > li > a {
    padding-left: 20px; /* Ajuste de espaçamento para submenus */
    background-color: #A52A2A; /* Fundo padrão transparente */
    color: #DAA520; /* Cor do texto padrão */
    transition: background-color 0.6s, color 0.6s; /* Transição suave */
}

/* Adicionando borda ou sombra opcional no hover */
#menu ul.nav > li > a:hover,
#menu ul.nav > li > ul.nav-second-level > li > a:hover {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    background-color: #A52A2A; /* Fundo padrão transparente */
    color: #fff; /* Cor do texto padrão */
}

/* Melhorando a visualização do submenu */
#menu ul.nav ul.nav-second-level {
    border-radius: 5px; /* Bordas arredondadas para submenus */
    overflow: hidden; /* Garante que os itens não "vazem" */
    margin-top: 5px; /* Distância entre submenu e item principal */
}

</style>

