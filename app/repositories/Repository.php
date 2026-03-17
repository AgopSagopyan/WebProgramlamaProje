<?php
    class Repository {
        private $_pdo;

        public function __construct($pdo) {
            $this->_pdo = $pdo;
        }

        public function insert($name, $email) {
            $stmt = $this->_pdo->prepare(
                "INSERT INTO users (name, email)" .
                "VALUES (?, ?)"
            );

            return $stmt->execute([$name, $email]);

        }

    }

?>