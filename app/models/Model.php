<?php

/*
require "/../config/database.php";

class Model {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addMovie($name, $genre, $coverPath = null) {
        if($coverPath) {
            $sql = "INSERT INTO movies ()";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':genre' => $genre,
                ':cover' => $coverPath

            ]);
        } else {

            $sql = "INSERT INTO movies (movie_name, movie_genre) VALUES (:name, :genre)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':genre' => $genre
            ]);
        }
    }

}
    */

//require_once __DIR__ . '/../config/database.php';

class Model {

    private $_pdo;
    private $_repository;

    public function __construct($pdo, $repository) {
        $this->_pdo = $pdo;
        $this->_repository = $repository;

    }

    public function yazdir($text) {
        return $text;
    }

    public function createUser($name, $email) {
        return $this->_repository->insert($name, $email);
    }
}

?>