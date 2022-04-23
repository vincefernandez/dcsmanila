<?php
  class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    
    private $option = array(
      PDO::ATTR_ERRMODE =>
      PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE =>
      PDO::FETCH_ASSOC
    );

    protected function connect() {
      $this->host = "localhost";
      $this->dbname = "dcs_manila";
      $this->username = "root";
      $this->password = "";
      // $this->host = "sql201.epizy.com";
      // $this->dbname = "epiz_31524705_dcs_manila";
      // $this->username = "epiz_31524705";
      // $this->password = "ZJYJ6suz1HgA";

      try {
        $dsn = "mysql:host=". $this->host . ";dbname=" . $this->dbname;
        $conn = new PDO($dsn, $this->username, $this->password, $this->option);
        return $conn;
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }
  }
?>