<?php
include 'Client.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifique se o parâmetro 'id' foi enviado
    if (isset($_POST['id'])) {
        $client = new Client();
        $clientId = $_POST['id'];

        // Realize a exclusão do cliente
        $result = $client->deleteClient($clientId);

        if ($result) {
            // Responda com sucesso (você pode personalizar a resposta conforme necessário)
            echo json_encode(['success' => true]);
            exit();
        } else {
            // Responda com erro (você pode personalizar a resposta conforme necessário)
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir o cliente.']);
            exit();
        }
    } else {
        // Responda com erro se o parâmetro 'id' não foi fornecido
        echo json_encode(['success' => false, 'message' => 'Parâmetro "id" ausente.']);
        exit();
    }
} else {
    // Responda com erro se a requisição não for do tipo POST
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
    exit();
}
?>
