<?php
include 'User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $user = new User();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user->register($username, $password);

        header("Location: index.php");
        exit();
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = new User();
        $userId = $user->login($username, $password);

        if ($userId) {
            $_SESSION['user_id'] = $userId;

            header("Location: clients.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Nome de usuário ou senha incorretos.";

            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Slide Navbar</title>
  <link rel="stylesheet" type="text/css" href="slide navbar style.css">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <div class="signup">
      <form method="POST">
        <label for="chk" aria-hidden="true">Cadastro</label>
        <?php

          if (isset($_SESSION['msg-register'])) {
            printf(
              '<label class="msg-error" aria-hidden="true">%s</label>'
              , $_SESSION['msg-register']
            );

            unset($_SESSION['msg-register']);
          }

        ?>
        <input type="text" name="username" placeholder="User" required="">
        <input type="password" name="pswd" placeholder="Password" required="">
        <button type="submit" name="register">Cadastrar</button>
      </form>
    </div>

    <div class="login">
      <form method="POST">
        <label for="chk" aria-hidden="true">Login</label>
        <?php

          if (isset($_SESSION['msg-login'])) {
            printf(
              '<label class="msg-error" aria-hidden="true">%s</label>'
              , $_SESSION['msg-login']
            );

            unset($_SESSION['msg-login']);
          }

        ?>

        <input type="text" name="username" placeholder="User" required="">
        <input type="password" name="pswd" placeholder="Password" required="">
        <button type="submit" name="login">Login</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>