<?php
  class QueueNo extends Database {

    public function getQueueNoByCategory($category_id) {
      $conn = $this->connect();

      $sql = "
      SELECT
        queue_id,
        counter,
        value,
        modified_date
      FROM queue_no
      WHERE category_id = :category_id;";

      $stmt = $conn->prepare($sql);
      $stmt->execute(["category_id" => $category_id]);
      $result = $stmt->fetch();
      
      return $result;
    }

    public function updateQueueNo($id, $counter, $value) {
      $conn = $this->connect();

      $sql = "
      UPDATE queue_no
      SET
        counter = :counter,
        value = :value
      WHERE queue_id = :id;";

      $stmt = $conn->prepare($sql);
      $stmt->execute(["id" => $id, "counter" => $counter, "value" => $value]);
    }
  }
?>