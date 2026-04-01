<?php

class DB{
    private PDO $db;

    public function __construct($host = "localhost", $dbName = "comparo_full", $dbUser = 'root', $password = ""){
        $temp = "mysql:host=" . $host . ";dbname=" . $dbName;
        try
        {
            //$this->db = new PDO('mysql:host=localhost;dbname=quiz', 'root', "");
            $this->db = new PDO($temp, $dbUser, $password);
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getDataBase(){
        return $this->db;
    }
}
    
?>