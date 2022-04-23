<?php
  class RrmRecordTracking extends Database {

    public function addRecord($id, $remarks) {
      $conn = $this->connect();

      $sql = "
      SET @record_id = :id;

      SELECT
        @status_id := status_id,
        @office_id := office_id,
        @section_id := section_id
      FROM rrm_record
      WHERE record_id = @record_id;
    
      INSERT INTO rrm_record_tracking(record_id, status_id, office_id, section_id, remarks)
      VALUES
        (@record_id, @status_id, @office_id, @section_id, :remarks);";

      $stmt = $conn->prepare($sql);
      $stmt->execute(["id" => $id, "remarks" => $remarks]);
    }
  }
?>