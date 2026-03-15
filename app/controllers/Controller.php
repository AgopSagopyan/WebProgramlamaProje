<?php

require_once __DIR__ . '/../models/User.php';

class UserRepository
{
    private $_userModel;

    public function __construct($db)
    {
        $this->_userModel = new User($db);
    }

    public function index()
    {
        $users = $this->_userModel->getAllUsers();

        require __DIR__ . '/../views/index.php';
    }
}
