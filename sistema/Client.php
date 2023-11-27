<?php

require './Database.php';

class Client extends Database {
    public function addClient($codigo, $name, $email) {
        $stmt = $this->conn->prepare("INSERT INTO CLIENTE (CODIGO, NOME, EMAIL) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $codigo, $name, $email);
        $stmt->execute();
        $stmt->close();
    }

    public function getClients() {
        $result = $this->conn->query("SELECT * FROM CLIENTE");
        $clients = [];

        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }

        return $clients;
    }

    public function editClient($id, $name, $email) {
        $stmt = $this->conn->prepare("UPDATE CLIENTE SET NOME = ?, EMAIL = ? WHERE ID = ?");
        $stmt->bind_param("ssi", $name, $email, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteClient($id) {
        $stmt = $this->conn->prepare("DELETE FROM CLIENTE WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getClientById($id) {
      $stmt = $this->conn->prepare("SELECT ID, NOME, EMAIL FROM CLIENTE WHERE ID = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $client = $result->fetch_assoc();
      $stmt->close();

      return $client;
  }
}
?>
