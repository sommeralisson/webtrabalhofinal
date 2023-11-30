<?php

namespace app\sistema;

session_start();

require 'Database.php';

class User extends \app\sistema\Database {
  public function fRegister($sUsername, $sPassword) {
    if ($this->fIsUsernameTaken($sUsername)) {
      $_SESSION['msg-register'] = 'Usuário já registrado. Escolha outro nome de usuário.';

      return false;
    }

    $sHashedPassword = password_hash($sPassword, PASSWORD_DEFAULT);

    $oStmt = $this->oConn->prepare("INSERT INTO USUARIO (USERNAME, PASSWORD) VALUES (?, ?)");

    $oStmt->bind_param("ss", $sUsername, $sHashedPassword);
    $oStmt->execute();
    $oStmt->close();

    return true;
  }

  public function fLogin($sUsername, $sPassword) {
    $oStmt = $this->oConn->prepare("SELECT ID, PASSWORD FROM USUARIO WHERE USERNAME = ?");

    $oStmt->bind_param("s", $sUsername);
    $oStmt->execute();
    $oStmt->bind_result($sId, $sHashedPassword);
    $oStmt->fetch();
    $oStmt->close();

    if (password_verify($sPassword, $sHashedPassword)) {
      return $sId;
    } else {
      $_SESSION['msg-login'] = 'Nome de usuário ou senha incorretos.';

      return;
    }
  }

  private function fIsUsernameTaken($sUsername) {
    $oStmt = $this->oConn->prepare("SELECT COUNT(*) FROM USUARIO WHERE USERNAME = ?");
    $oStmt->bind_param("s", $sUsername);
    $oStmt->execute();
    $oStmt->bind_result($nCount);
    $oStmt->fetch();
    $oStmt->close();

    return $nCount > 0;
  }
}

?>
