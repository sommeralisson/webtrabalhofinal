<?php
require_once '../class/Client.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

$oClient = new \app\sistema\Client();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fEditClient'])) {
  $sEditClientId    = $_POST['editClientId'];
  $sEditClientName  = $_POST['editClientName'];
  $sEditClientEmail = $_POST['editClientEmail'];

  $oClient->fEditClient($sEditClientId, $sEditClientName, $sEditClientEmail);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fDeleteClient'])) {
  $sDeleteClientId = $_POST['deleteClientId'];

  $oClient->fDeleteClient($sDeleteClientId);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fAddClient'])) {
  $sName  = $_POST['name'];
  $sEmail = $_POST['email'];

  $oClient->fAddClient($codigo, $sName, $sEmail);

  header("Location: clients.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filterInput'])) {
  $sFiltro = $_POST['filterInput'];
}

$aClients = $oClient->fGetClients($sFiltro);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <div style="display: flex;justify-content:space-between;">
      <div>
        <h2 class="mb-4">Lista de Clientes</h2>
      </div>
      <div>
        <button class="btn btn-warning" onclick="filtrar()" style="max-height: 40px;">Filtrar</button>
        <a href="clients.php" class="btn btn-primary" style="max-height: 40px;">Limpar Filtro</a>
        <a href="add_client.php" class="btn btn-success" style="max-height: 40px;">Novo Cliente</a>
      </div>
    </div>

    <form action="" id="filtro" method="POST">
      <input type="text" name="filterInput" id="filterInput" class="form-control mb-3" placeholder="Filtrar por nome">
    </form>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Código</th>
          <th scope="col">Nome</th>
          <th scope="col">Sobrenome</th>
          <th scope="col">E-mail</th>
          <th scope="col">Data Nascimento</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody id="clientList">
        <?php foreach ($aClients as $oClient) : ?>
          <tr data-codigo='<?= $oClient['ID'] ?>'>
            <td><?= $oClient['CODIGO'] ?></td>
            <td><?= $oClient['NOME'] ?></td>
            <td><?= $oClient['SOBRENOME'] ?></td>
            <td><?= $oClient['EMAIL'] ?></td>
            <td><?= $oClient['DATA_NASCIMENTO'] ?></td>
            <td>
              <a href="edit_client.php?id=<?= $oClient['ID'] ?>" class="btn btn-primary btn-sm">Editar</a>
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?= $oClient['ID'] ?>">
                Excluir
              </button>

              <div class="modal fade" id="confirmDeleteModal<?= $oClient['ID'] ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p>Tem certeza de que deseja excluir o cliente <?= $oClient['NOME'] ?>?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-danger" onclick="jConfirmDelete(<?= $oClient['ID'] ?>)">Confirmar Exclusão</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="../resources/logout.php" class="btn btn-danger">Sair</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../js/script.js"></script>

</body>
</html>
