<?php

require '../class/Client.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sName   = $_POST['name'];
  $sEmail  = $_POST['email'];
  $sId     = $_POST['codigo'];
  $oClient = new \app\sistema\Client();

  $oClient->fAddClient($sId, $sName, $sEmail);

  header("Location: clients.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Novo Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      padding: 20px;
    }

    form {
      max-width: 400px;
      margin: auto;
    }
  </style>
</head>

<body>
  <form method="post">
    <h2 class="mb-4">Adicionar Novo Cliente</h2>
    <div class="mb-3">
      <label for="codigo" class="form-label">Código:</label>
      <input type="number" class="form-control" id="codigo" name="codigo" required>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Nome:</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-mail:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <button type="submit" class="btn btn-primary">Adicionar Cliente</button>
    <a href="clients.php" class="btn btn-secondary">Cancelar</a>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
