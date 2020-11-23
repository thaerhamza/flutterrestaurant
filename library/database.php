<?php
class database{
    private $host = "localhost";
    private $db_name ="db_restaurant";
    private $username = "root";
    private $password = "";
    public $conn;

    // get connection

    public function getConnection()
    {
        $this->conn =null;

        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=".$this->db_name ,$this->username ,$this->password);
            $this->conn->exec("set names utf8mb4");            
        }
        catch(PDOException $exception)
        {
            echo "connection error " . $exception->getMessage();
        }
    }
}
