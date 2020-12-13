<?php
class DB {
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "todos";

  public function conn() {
      $dsn = "mysql:host=".$this->host.";dbname=".$this->db;
      $conn = new PDO($dsn,$this->user,$this->pass);
      $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      return $conn;
  }
}
?>
