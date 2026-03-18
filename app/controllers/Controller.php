<?php
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../repositories/Repository.php';
//require_once __DIR__ . '/../views/anasayfa.php';

class Controller {

    private $_pdo;
    private $_repository;
    private $_service;

    public function __construct($pdo, $service) {
        $this->_pdo = $pdo;
        $this->_repository = new Repository($this->_pdo);
        $this->_service = $service;
    }


    public function bisey() {
        $model = new Model($this->_pdo, $this->_repository);
        $result = $model->yazdir("Merhaba zenci");

        require_once __DIR__ . '/../views/mvcdeneme.php';
    }

    public function navigateTo() {
        $this->_service->navigateTo("/app/views/mvcdeneme.php");
    }


}

?>
