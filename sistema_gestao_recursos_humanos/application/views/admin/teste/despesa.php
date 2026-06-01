<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Despesa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h2>Inserir Despesa</h2>

    <!-- Exibição de erros de validação -->
    <?php if (validation_errors()) : ?>
      <div class="alert alert-danger">
        <?= validation_errors(); ?>
      </div>
    <?php endif; ?>

    <!-- Formulário -->
    <form action="<?= site_url('despesa/insert'); ?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="id_pedido_viagem">Pedido de Viagem:</label>
        <select class="form-control" id="id_pedido_viagem" name="id_pedido_viagem" required>
          <!-- Aqui você pode preencher com os pedidos de viagem disponíveis -->
          <option value="">Selecione o Pedido de Viagem</option>
          <!-- Exemplo de opções -->
          <option value="1">Pedido 1</option>
          <option value="2">Pedido 2</option>
          <option value="3">Pedido 3</option>
        </select>
      </div>

      <div class="form-group">
        <label for="despesa">Despesa:</label>
        <input type="text" class="form-control" id="despesa" name="despesa" value="<?= set_value('despesa'); ?>" required>
      </div>

      <div class="form-group">
        <label for="valor">Valor:</label>
        <input type="text" class="form-control" id="valor" name="valor" value="<?= set_value('valor'); ?>" required>
      </div>

      <div class="form-group">
        <label for="comprovante">Comprovante (Arquivo):</label>
        <input type="file" class="form-control" id="comprovante" name="comprovante" required>
      </div>

      <button type="submit" class="btn btn-primary">Salvar Despesa</button>
    </form>
  </div>

  <!-- Scripts do Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>