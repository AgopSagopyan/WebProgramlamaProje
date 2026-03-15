<?php

class User
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAllUsers()
    {
        $stmt = $this->_db->query("SELECT name FROM users");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
