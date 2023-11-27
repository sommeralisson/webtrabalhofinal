<?php
// Encerrar a sessão
session_start();
session_destroy();

// Redirecionar para a página de login
header("Location: index.php");
exit();
?>
