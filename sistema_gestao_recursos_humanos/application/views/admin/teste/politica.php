<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Cadastro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h2>Cadastrar Novo Item</h2>

    <!-- Exibição de erros de validação -->
    <?php if (validation_errors()) : ?>
      <div class="alert alert-danger">
        <?= validation_errors(); ?>
      </div>
    <?php endif; ?>

    <!-- Formulário -->
    <form action="<?= site_url('cadastrar/insert'); ?>" method="post">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?= set_value('nome'); ?>" required>
      </div>

      <div class="form-group">
        <label for="descricao">Descrição:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= set_value('descricao'); ?></textarea>
      </div>

      <div class="form-group">
        <label for="funcionario_id">ID do Funcionário:</label>
        <input type="number" class="form-control" id="funcionario_id" name="funcionario_id" value="<?= set_value('funcionario_id'); ?>" required>
      </div>

      <div class="form-group">
        <label for="status_id">ID de Status:</label>
        <input type="number" class="form-control" id="status_id" name="status_id" value="<?= set_value('status_id'); ?>" required>
      </div>

      <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
  </div>

  <!-- Scripts do Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>