<?php
  class Category extends Database {

    public function getCategoryById($id) {
      $conn = $this->connect();

      $sql = "
      SELECT
        category_id,
        name
      FROM category
      WHERE category_id = :id;";

      $stmt = $conn->prepare($sql);
      $stmt->execute(["id" => $id]);
      $result = $stmt->fetch();
      
      return $result;
    }
  }
?>