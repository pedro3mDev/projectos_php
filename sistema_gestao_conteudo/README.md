# sistema_gestao_conteudo
# Nova Press

O Sistema de Gestão de Conteúdo Moderno é uma aplicação web desenvolvida em Laravel, projetada para facilitar a criação, edição, publicação e gestão de artigos online de forma rápida, segura e intuitiva.
A plataforma permite que autores e administradores colaborem na produção de conteúdo digital, enquanto o público pode aceder facilmente aos artigos publicados através de uma interface moderna e responsiva.
Com integração de upload de imagens, editor de texto avançado (WYSIWYG) e painel estatístico interativo, o sistema oferece uma experiência completa para quem deseja gerir um site de notícias, blog profissional, revista digital ou portal informativo.

# Principais Funcionalidades
1.Gestão de Utilizadores e Permissões
  Sistema de autenticação seguro com diferentes papéis de acesso:
  Administrador: gere utilizadores, categorias e publicações.
  Editor: cria e edita artigos, sem acesso a configurações críticas.
  Leitor: acede apenas ao conteúdo público.
  Gestão completa de contas (criar, editar, remover).

2.Gestão de Artigos
  Criar, editar, publicar e despublicar artigos.
  Editor de texto WYSIWYG (TinyMCE ou Quill) para formatação rica.
  Upload e gestão de imagens de capa diretamente no formulário.
  Contador automático de visualizações.
  Organização por categorias e tags.

3.Dashboard Administrativo
  Painel interativo que exibe:
  Total de artigos, utilizadores e categorias.
  Gráficos de publicações mensais.
  Artigos mais visualizados.
  Autores mais ativos.
  Estatísticas geradas em tempo real com Chart.js ou Livewire Charts.

4.Área Pública (Frontend)
  Página inicial com lista de artigos publicados, com imagem, título, resumo e data.
  Página de detalhe do artigo com autor, categoria e contador de visualizações.
  Filtros por categoria e campo de pesquisa rápida.
  Design moderno, responsivo e com modo escuro (dark mode).

5.API REST Integrada
  Disponibiliza uma API segura para integração com aplicações externas (por exemplo, apps móveis).
  Endpoints para listar, criar, editar e apagar artigos (autorização via Laravel Sanctum).
  Ideal para ampliar o projeto para um frontend separado (Vue, React, Flutter, etc.).

6.Funcionalidades Extras
  Sistema opcional de comentários moderados por artigo.
  Envio automático de notificações por e-mail quando novos conteúdos são publicados.
  SEO automático, com geração de meta tags e URLs otimizadas.
  Suporte a modo escuro/claro no painel administrativo.

