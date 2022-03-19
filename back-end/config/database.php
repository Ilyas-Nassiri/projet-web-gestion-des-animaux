<?php

class Database
{
    // properties
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    // methode connect
    protected function connect()
    {
        $this->servername = "localhost"; //localhost
        $this->username = "root"; //root
        $this->password = ""; //password
        $this->dbname = "animaux"; //database name
        $this->charset = "utf8mb4";
        //connect to database using pdo 
        try {
            $dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "connection fieled ERR_01";
        }
    }
}
