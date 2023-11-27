<?php
include 'Client.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: clients.php");
    exit();
}

$client = new Client();

$clientDetails = $client->getClientById($_GET['id']);

// Verifique se o cliente foi encontrado
if (!$clientDetails) {
    // Redirecione de volta à lista de clientes se o cliente não for encontrado
    header("Location: clients.php");
    exit();
}

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Faça as atualizações no cliente
    $name = $_POST['name'];
    $email = $_POST['email'];

    $client->editClient($_GET['id'], $name, $email);

    // Redirecione de volta à lista de clientes após a atualização
    header("Location: clients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>

    <!-- Adicione o link para o Bootstrap (versão online ou faça o download) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Adicione estilos personalizados aqui se necessário */
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

    <!-- Formulário de Edição do Cliente -->
    <form method="post">
        <h2 class="mb-4">Editar Cliente</h2>
        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $clientDetails['NOME'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $clientDetails['EMAIL'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="clients.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <!-- Adicione o link para o Bootstrap (versão online ou faça o download) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
