<?php
  class Queuing extends Database {

    public function getQueues($category_id, $status_id) {
      $conn = $this->connect();

      $sql = "
      SELECT
        que.queue_no,
        rec.record_id,
        rec.control_no,
        rec.client_name
      FROM queuing as que
      LEFT JOIN record as rec
        ON que.record_id = rec.record_id
      LEFT JOIN rrm_record as rrm
        ON rec.record_id = rrm.record_id
      WHERE que.created_date >= curdate()
        AND rec.category_id = :category_id
        AND rrm.status_id = :status_id";

      $stmt = $conn->prepare($sql);
      $stmt->execute(["category_id" => $category_id, "status_id" => $status_id]);
      $result = $stmt->fetchAll();
      
      return $result;
    }

    public function addQueue($id, $queue_no) {
      $conn = $this->connect();

      $sql = "
      INSERT INTO queuing(record_id, queue_no)
      VALUES
        (:id, :queue_no);";

      $stmt = $conn->prepare($sql);
      $stmt->execute(["id" => $id, "queue_no" => $queue_no]);
    }
  }
?>