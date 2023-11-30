<?php

namespace app\sistema;

require 'Database.php';

class Client extends \app\sistema\Database {
  public function fAddClient($sCodigo, $sName, $sEmail) {
    $oStmt = $this->oConn->prepare("INSERT INTO CLIENTE (CODIGO, NOME, EMAIL) VALUES (?, ?, ?)");

    $oStmt->bind_param("sss", $sCodigo, $sName, $sEmail);
    $oStmt->execute();
    $oStmt->close();
  }

  public function fGetClients($sFiltro = '') {
    $sSql = sprintf(
      '
         SELECT *
           FROM CLIENTE
             %s
      ', !empty($sFiltro) ? sprintf('WHERE NOME LIKE \'%%%s%%\'', $sFiltro) : ''
    );

    $oResult  = $this->oConn->query($sSql);

    $aClients = [];

    while ($aRow = $oResult->fetch_assoc()) {
      $aClients[] = $aRow;
    }

    return $aClients;
  }

  public function fEditClient($sId, $sName, $sEmail) {
    $oStmt = $this->oConn->prepare("UPDATE CLIENTE SET NOME = ?, EMAIL = ? WHERE ID = ?");

    $oStmt->bind_param("ssi", $sName, $sEmail, $sId);
    $oStmt->execute();
    $oStmt->close();
  }

  public function fDeleteClient($sId) {
    try {
      $oStmt = $this->oConn->prepare("DELETE FROM CLIENTE WHERE ID = ?");

      $oStmt->bind_param("i", $sId);
      $oStmt->execute();
      $oStmt->close();

      return $sId;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function fGetClientById($sId) {
    $oStmt = $this->oConn->prepare("SELECT ID, NOME, EMAIL FROM CLIENTE WHERE ID = ?");

    $oStmt->bind_param("i", $sId);
    $oStmt->execute();

    $oResult = $oStmt->get_result();
    $aClient = $oResult->fetch_assoc();

    $oStmt->close();

    return $aClient;
  }
}
?>
