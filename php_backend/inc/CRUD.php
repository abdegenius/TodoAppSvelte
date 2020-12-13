<?php
include 'DB.php';
class CRUD extends DB {
  public function create($data, $column, $table) {
    $numberOfParameters = count($data);
    $getBinders = str_repeat(",?", $numberOfParameters);
    $binders = substr($getBinders,1);
    $sql = "INSERT INTO `{$table}`($column) VALUES($binders)";
    $query = $this->conn()->prepare($sql);
    $query->execute($data);
    if($query->rowCount() > 0){ return 1; }
    if($query->rowCount() == 0){ return 0; }
  }
  public function read($data, $column, $table) {
    $countData = count($data);
    $columns = "";
    if($countData > 1){
      $column = $column.",";
      $prepareColumns = str_replace(",", "=? &&", $column);
      $columns = substr($prepareColumns, 0, -2);
    }
    if($countData == 1){
      $columns = $column."=?";
    }
    $sql = "SELECT * FROM `{$table}` WHERE $columns ORDER BY id DESC";
    $query = $this->conn()->prepare($sql);
    $query->execute($data);
    if($query->rowCount() > 0){
      return $query->fetch();
    }
    if($query->rowCount() == 0){ return 0; }
  }

  public function readOR($data, $column, $table) {
    $countData = count($data);
    $columns = "";
    if($countData > 1){
      $column = $column.",";
      $prepareColumns = str_replace(",", "=? ||", $column);
      $columns = substr($prepareColumns, 0, -2);
    }
    if($countData == 1){
      $columns = $column."=?";
    }
    $sql = "SELECT * FROM `{$table}` WHERE $columns ORDER BY id DESC";
    $query = $this->conn()->prepare($sql);
    $query->execute($data);
    if($query->rowCount() > 0){
      return $query;
    }
    if($query->rowCount() == 0){ return 0; }
  }

  public function update($data, $column, $identity, $identifier, $table) {
    $countData = count($data);
    $columns = "";
    if($countData > 1){
      $column = $column.",";
      $prepareColumns = str_replace(",", " = ?,", $column);
      $columns = substr($prepareColumns, 0, -1);
    }
    if($countData == 1){
      $columns = $column." = ?";
    }
    $data[] = $identifier;
    $sql = "UPDATE `{$table}` SET $columns WHERE $identity = ?";
    $query = $this->conn()->prepare($sql);
    $query->execute($data);
    if($query->rowCount() > 0){ return 1; }
    if($query->rowCount() == 0){ return 0; }
  }

  public function delete($identifier, $identity, $table) {
    $sql = "DELETE FROM `{$table}` WHERE $identity = ?";
    $query = $this->conn()->prepare($sql);
    $query->execute($identifier);
    if($query->rowCount() > 0){ return 1; }
    if($query->rowCount() == 0){ return 0; }
  }

  public function user($data, $column, $table) {
    $sql = "SELECT * FROM `{$table}` WHERE $column = ?";
    $query = $this->conn()->prepare($sql);
    $query->execute([$data]);
    if($query->rowCount() > 0){
      return $query;
    }
    if($query->rowCount() == 0){ return 0; }
  }

  public function get($data, $column, $item, $table) {
    $sql = "SELECT * FROM `{$table}` WHERE $column = ?";
    $query = $this->conn()->prepare($sql);
    $query->execute($data);
    if($query->rowCount() > 0){
      $row = $query->fetch();
      return $row->{$item};
    }
    if($query->rowCount() == 0){ return 0; }
  }

  public function count($data, $data1, $column, $item, $table) {
    $query = 0;
    if($column == ""){
      $query = $this->conn()->query("SELECT COUNT(*) FROM `{$table}` WHERE $item = '$data'")->fetchColumn();
    }
    if($column != ""){
      $query = $this->conn()->query("SELECT COUNT(*) FROM `{$table}` WHERE $item = '$data' && $column = '$data1'")->fetchColumn();
    }
    return $query;
  }

  public function sum($col, $data, $data1, $column, $item, $table) {
    $query = 0;
    if($column == ""){
      $query = $this->conn()->query("SELECT SUM($col) FROM `{$table}` WHERE $item = '$data'")->fetchColumn();
    }
    if($column != ""){
      $query = $this->conn()->query("SELECT SUM($col) FROM `{$table}` WHERE $item = '$data' && $column = '$data1'")->fetchColumn();
    }
    return $query;
  }

  public function readLimit($data, $column, $limit, $table) {
    $countData = count($data);
    $columns = "";
    if($countData > 1){
      $column = $column.",";
      $prepareColumns = str_replace(",", "=? &&", $column);
      $columns = substr($prepareColumns, 0, -2);
    }
    if($countData == 1){
      $columns = $column."=?";
    }
    $sql = "SELECT * FROM `{$table}` WHERE $columns ORDER BY id DESC LIMIT $limit";
    $query = $this->conn()->prepare($sql);
    $query->execute($data);
    if($query->rowCount() > 0){
      return $query;
    }
    if($query->rowCount() == 0){ return 0; }
  }

  public function all($table) {
    $sql = "SELECT * FROM `{$table}`";
    $query = $this->conn()->prepare($sql);
    $query->execute();
    if($query->rowCount() > 0){
      return $query->fetchAll();
    }
    if($query->rowCount() == 0){ return 0; }
  }


}
?>
