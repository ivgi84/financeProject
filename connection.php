<?php


class dbConnect{

    private $dbServer="localhost";
    private $dbUser="ivgi";
    private $dbPass="ivgi123";
    private $dbName="finance";
    private $conn;

    function getConnected(){
        $this->conn= new mysqli($this->dbServer,$this->dbUser,$this->dbPass,$this->dbName);

        if($this->conn->connect_error){
            trigger_error('Database connection error: '.$this->conn->connect_error,E_USER_ERROR);
        }

        return $this->conn;
    }
}
