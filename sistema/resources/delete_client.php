<?php
require_once '../class/Client.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['id'])) {
    $oClient   = new \app\sistema\Client();
    $sClientId = $_POST['id'];
    $xResult   = $oClient->fDeleteClient($sClientId);

    if ($xResult) {
      echo json_encode(['success' => true, 'message' => 'Sucesso ao excluir o cliente.', 'id' => $xResult]);
      exit();
    } else {
      echo json_encode(['success' => false, 'message' => 'Erro ao excluir o cliente.']);
      exit();
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Parâmetro "id" ausente.']);
    exit();
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
  exit();
}
