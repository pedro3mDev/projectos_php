<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Feedback</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h2>Inserir Novo Feedback</h2>
    <form action="<?= site_url('feedback/insert'); ?>" method="post">
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
        <label for="id_funcionario">Funcionário:</label>
        <select class="form-control" id="id_funcionario" name="id_funcionario" required>
          <!-- Aqui você pode preencher com os funcionários disponíveis -->
          <option value="">Selecione o Funcionário</option>
          <!-- Exemplo de opções -->
          <option value="1">Funcionário 1</option>
          <option value="2">Funcionário 2</option>
          <option value="3">Funcionário 3</option>
        </select>
      </div>

      <div class="form-group">
        <label for="feedback">Feedback:</label>
        <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Enviar Feedback</button>
    </form>
  </div>

  <!-- Scripts do Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>