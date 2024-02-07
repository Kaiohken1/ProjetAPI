<?php
include_once "../repository/UserRepository.php";
include_once "../config/Database.php";

class UserService {
    private $repository;

    function __construct() {
        $database = new Database();
        $db = $database->getConnection();

        $this->userRepository = new UserRepository($db);
    }

    function createUser($userObject) {
        $nom = $userObject->nom;
        $role = $userObject->role;

        return $this->repository->createUser($userObject);
    }
}
?>