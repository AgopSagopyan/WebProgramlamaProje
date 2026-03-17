<?php
/*

require_once __DIR__ . '/app/models/Model.php';

class Controller
{
    private $_userModel;

    public function __construct($db)
    {
        $this->_userModel = new User($db);
    }

    public function index()
    {
        $users = $this->_userModel->getAllUsers();

        require __DIR__ . '/app/views/index.php';
    }
}
*/

require_once __DIR__ . '/../models/Model.php';
//require_once __DIR__ . '/../views/anasayfa.php';

class Controller {

    private $_pdo;

    public function __construct($pdo) {
        $this->_pdo = $pdo;
    }


    public function bisey() {
        $model = new Model($this->_pdo);
        $result = $model->yazdir("Merhaba zenci");

        require_once __DIR__ . '/../views/mvcdeneme.php';
    }


}

?>
