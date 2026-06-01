</br>
</br>
</br>
</br>
</br>
</br>
</br>

<!--div class="content row" style="position: relative; overflow: hidden; border-radius: 30px; border-bottom: 1px solid red; background-color: #336; padding: 10px;"--
<div class="content row" style="position: fixed; top: 60px; left: 250px; width: 87%; overflow: hidden; border-radius: 30px; border-bottom: 1px solid red; background-color: #336; padding: 10px; z-index: 999;">

    <!-- Botão de recuar --
    <button onclick="slide(-1)" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: #DAA520; color: #fff; border-radius: 20px; font-size: 14px; padding: 5px 10px; border: none; cursor: pointer; z-index: 10;">
        &#8249;
    </button>

    <!-- Lista --
    <ul id="carousel-list" style="list-style: none; padding: 0; margin: 0; display: inline-flex; gap: 20px; align-items: center; white-space: nowrap; transition: transform 0.5s;">
        <li class="carousel-item">
            <a href="" style="text-decoration: none; color: inherit;">
            </a>
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
                <i class="fas fa-user-tie"></i> Recrutamento e Seleção
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
                <i class="fas fa-handshake"></i> Gestão de Integração
            </a>
        </li>
        
        <li class="carousel-item">
            <a href="<?= admin_url('document_management/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                <i class="fas fa-folder-open"></i> Gestão Documental
            </a>
        </li>
        <li class="carousel-item">
            <a href="<?= admin_url('gestao_viagens/index'); ?>" style="text-decoration: none; color: inherit;">
                <i class="fas fa-plane"></i> Gestão de Viagens
            </a>
        </li>
        <li class="carousel-item">
            <a href="<?= admin_url('politicas_empresa/'); ?>" style="text-decoration: none; color: inherit;">
                <i class="fas fa-cogs"></i> Políticas de Empresas
            </a>
        </li>
        <li class="carousel-item">
            <a href="<?= admin_url('approvify/'); ?>" style="text-decoration: none; color: inherit;">
                <i class="fas fa-file-alt"></i> Requisições 
            </a>
        </li>
        <li class="carousel-item">
            <a href="<?= admin_url('gestao_assiduidade/dashboard'); ?>" style="text-decoration: none; color: inherit;">
                <i class="fas fa-calendar-check"></i> Gestão de Assiduidade
            </a>
        </li>
        
    </ul>

    <!-- Botão de avançar --
    <button onclick="slide(1)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #DAA520; color: #fff; border-radius: 20px; font-size: 14px; padding: 5px 10px; border: none; cursor: pointer; z-index: 10;">
        &#8250;
    </button>
</div>

<script>
    let currentIndex = 0;

    function slide(direction) {
        const list = document.getElementById('carousel-list');
        const items = Array.from(list.children);

        // A largura de cada item, incluindo o gap
        const itemWidth = items[0].offsetWidth + parseInt(getComputedStyle(list).gap || 0, 10);

        // Número de itens visíveis no contêiner
        const containerWidth = list.parentElement.offsetWidth;
        const visibleItems = Math.floor(containerWidth / itemWidth);

        // Índice máximo que pode ser alcançado
        const maxIndex = Math.max(0, items.length - visibleItems);

        // Atualiza o índice e garante que esteja dentro dos limites
        currentIndex += direction;
        currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));

        // Aplica a transformação para deslocar os itens
        list.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
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
</br>
</br>
</br>

        <!--li class="carousel-item">
            <i class="fas fa-users-cog"></i> Gestão de Desenvolvimento Individual
        </li>
        <li class="carousel-item">
            <i class="fas fa-arrow-up"></i> Gestão de Plano de Sucessão e Liderança
        </li>
        <li class="carousel-item">
            <i class="fas fa-wallet"></i> Gestão de Remunerações
        </li>
        <li class="carousel-item">
            <i class="fas fa-book"></i> Gestão de Formação
        </li>
        <li class="carousel-item">
            <i class="fas fa-users"></i> Planejamento de Força de Trabalho
        </li>
        <li class="carousel-item">
            <i class="fas fa-chart-line"></i> Produção de Relatórios
        </li>
        <li class="carousel-item">
            <i class="fas fa-star"></i> Engajamento de Talentos
        </li-->