

    <div class="content row" style="position: relative; overflow: hidden; border-radius: 30px; border-bottom: 1px solid red; background-color: #336; padding: 10px;">
         <!-- Botão de recuar -->
         <button onclick="slide(-1)" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: #DAA520; color: #fff; border-radius: 20px; font-size: 14px; padding: 5px 10px; border: none; cursor: pointer; z-index: 10;">
            &#8249; <!-- Ícone de seta esquerda -->
         </button>

         <!-- Lista -->
         <ul id="carousel-list" style="list-style: none; padding: 0; margin: 0; display: inline-flex; gap: 20px; align-items: center; height: 50px; transition: transform 0.5s;">
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-user-tie"></i> Recrutamento e Seleção
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-handshake"></i> Gestão de Integração
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-plane"></i> Gestão de Viagens
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-chart-line"></i> Produção de Relatórios
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-folder-open"></i> Gestão Documental
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-cogs"></i> Politicas de Empresas
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-calendar-check"></i> Gestão de Assiduidade
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-users-cog"></i> Gestão de Desenvolvimento Individual
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-arrow-up"></i> Gestão de Plano de Sucessão e Liderança
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-wallet"></i> Gestão de Remunerações
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-book"></i> Gestão de Formação
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-users"></i> Planeamento de Força de Trabalho
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-users-cog"></i> Gestão de Desenvolvimento Individual
            </li>
            <li class="carousel-item" style="width:300px; ">
               <i class="fas fa-star"></i> Engajamento de Talentos
            </li>
         </ul>

         <!-- Botão de avançar -->
         <button onclick="slide(1)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #DAA520; color: #fff; border-radius: 20px; font-size: 14px; padding: 5px 10px; border: none; cursor: pointer; z-index: 10;">
            &#8250; <!-- Ícone de seta direita -->
         </button>
      </div>
      </br>

      <script>
         let currentIndex = 0;

         function slide(direction) {
            const list = document.getElementById('carousel-list');
            const items = list.children;

            // A largura dos itens (com o espaçamento entre eles)
            const itemWidth = items[0].offsetWidth + 20; // Ajuste o valor do gap se necessário

            // Calcula o próximo índice
            currentIndex += direction;

            // Calcula o número máximo de itens visíveis na tela
            const maxIndex = Math.max(0, items.length - Math.floor(list.parentElement.offsetWidth / itemWidth));

            // Limita o índice ao intervalo válido
            if (currentIndex < 0) currentIndex = 0;
            if (currentIndex > maxIndex) currentIndex = maxIndex;

            // Atualiza o deslocamento da lista
            list.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
         }
      </script>


      <style>
         /* Estilo padrão dos itens */
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
         }

         /* Estilo padrão dos ícones */
         .carousel-item i {
            color: #fff;
            margin-right: 10px;
            transition: color 0.3s, transform 0.3s;
         }

         /* Estilo ao passar o mouse */
         .carousel-item:hover {
            color: #DAA520;
            transform: scale(1.05); /* Efeito de leve zoom */
         }

         .carousel-item:hover i {
            color: #DAA520;
            transform: scale(1.2); /* Leve aumento do ícone */
         }
      </style>