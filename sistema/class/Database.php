<?php

namespace app\sistema;

class Database {
  private $sHost     = 'host.docker.internal:3333';
  private $sUser     = 'root';
  private $sPassword = 'root';
  private $sDatabase = 'mysql01';

  protected $oConn;

  public function __construct() {
    $this->oConn = new \mysqli($this->sHost, $this->sUser, $this->sPassword, $this->sDatabase);

    if ($this->oConn->connect_error) {
      die("Connection failed: " . $this->oConn->connect_error);
    }
  }
}
