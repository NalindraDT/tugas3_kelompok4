<?php
class database{
    private $host = '160.19.166.42';
    private $db_name = '2C_klp4';
    private $username = '2C_klp4';
    private $password = 'sh4C@0Ya(.ti*Rob';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: ". $e->getMessage();
        }
        return $this->conn;
    }
}
?>