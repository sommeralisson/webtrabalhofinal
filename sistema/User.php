<?php
session_start();
require './Database.php';

class User extends Database {
    public function register($username, $password) {
      if ($this->isUsernameTaken($username)) {
        $_SESSION['msg-register'] = 'Usuário já registrado. Escolha outro nome de usuário.';

        return;
      }

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $this->conn->prepare("INSERT INTO USUARIO (USERNAME, PASSWORD) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $hashedPassword);
      $stmt->execute();
      $stmt->close();
    }

    public function login($username, $password) {
      $stmt = $this->conn->prepare("SELECT ID, PASSWORD FROM USUARIO WHERE USERNAME = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->bind_result($id, $hashedPassword);
      $stmt->fetch();
      $stmt->close();

      if (password_verify($password, $hashedPassword)) {
          return $id;
      } else {
        $_SESSION['msg-login'] = 'Nome de usuário ou senha incorretos.';

        return;
      }
    }

    private function isUsernameTaken($username) {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM USUARIO WHERE USERNAME = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->bind_result($count);
      $stmt->fetch();
      $stmt->close();

      return $count > 0;
  }
}
?>
