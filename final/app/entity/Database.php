<?php

namespace app\entity;

class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "projetPHPJC";
    private $username = "root";
    private $password = "jsa25580";
    private $conn;
    
     
    // get the database connection
    public function getConnection(){
 
        $this->conn = new \PDO("mysql:host=" . $this->host, $this->username, $this->password);

        //create the database if not created yet
        $query = $this->conn->query("SHOW DATABASES;") ; //call 'show db' to retrieve present databases
        $query = $query->fetchAll(\PDO::FETCH_ASSOC);
        if(!in_array($this->db_name, $query)){ //database present ?
            $this->conn->query("CREATE DATABASE ".$this->db_name.";"); //create if its not the case.
        }
        
        try{
            $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }
        catch(\PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>