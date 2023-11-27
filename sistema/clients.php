<?php
include 'Client.php';

// Verificar se o usuário está autenticado
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$client = new Client();

// Editar Cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editClient'])) {
    $editClientId = $_POST['editClientId'];
    $editClientName = $_POST['editClientName'];
    $editClientEmail = $_POST['editClientEmail'];

    $client->editClient($editClientId, $editClientName, $editClientEmail);
}

// Excluir Cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteClient'])) {
    $deleteClientId = $_POST['deleteClientId'];
    $client->deleteClient($deleteClientId);
}

// Adicionar cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addClient'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $client->addClient($codigo, $name, $email);

  header("Location: clients.php");
}

$clients = $client->getClients();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-4">
        <div style="display: flex;justify-content:space-between;">
            <h2 class="mb-4">Lista de Clientes</h2>
            <a href="add_client.php" class="btn btn-success" style="max-height: 40px;">Novo Cliente</a>
        </div>
        <input type="text" id="filterInput" class="form-control mb-3" placeholder="Filtrar por nome">

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
                <?php foreach ($clients as $client) : ?>
                    <tr>
                        <td><?= $client['CODIGO'] ?></td>
                        <td><?= $client['NOME'] ?></td>
                        <td><?= $client['SOBRENOME'] ?></td>
                        <td><?= $client['EMAIL'] ?></td>
                        <td><?= $client['DATA_NASCIMENTO'] ?></td>
                        <td>
                            <a href="edit_client.php?id=<?= $client['ID'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?= $client['ID'] ?>">
                                Excluir
                            </button>

                            <!-- Modal de Confirmação de Exclusão -->
                            <div class="modal fade" id="confirmDeleteModal<?= $client['ID'] ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza de que deseja excluir o cliente <?= $client['NOME'] ?>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $client['ID'] ?>)">Confirmar Exclusão</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Adicione o link para o Bootstrap (versão online ou faça o download) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Adicione o script JavaScript para filtrar a tabela e confirmar a exclusão -->
    <script>
        document.getElementById('filterInput').addEventListener('input', function () {
            var filterValue = this.value.toLowerCase();
            var clientList = document.getElementById('clientList');
            var rows = clientList.getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var name = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                if (name.includes(filterValue)) {
                    rows[i].style.display = 'table-row';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });

      // ...

function confirmDelete(clientId) {
    // Exibir modal de carregamento enquanto a requisição está em andamento
    $('#confirmDeleteModal' + clientId).modal('hide'); // Esconder modal de confirmação
    $('#loadingModal').modal('show'); // Exibir modal de carregamento

    // Realizar a exclusão do cliente utilizando Ajax
    $.ajax({
        url: 'delete_client.php',
        type: 'POST',
        data: { id: clientId },
        success: function (response) {
            // Esconder modal de carregamento
            $('#loadingModal').modal('hide');

            // Recarregar a página
            location.reload();
        },
        error: function (xhr, status, error) {
            // Esconder modal de carregamento
            $('#loadingModal').modal('hide');

            // Exibir mensagem de erro (você pode personalizar conforme necessário)
            alert('Erro ao excluir o cliente. Tente novamente.');
        }
    });
}

    </script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>
</html>