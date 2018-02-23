<?php
class Manager{
    protected $db;

    public function __construct($db){
        $this->setDb($db);
    }
    public function setDb(PDO $db){
        $this->db = $db;
    }
}