<?php
include_once "./repository/UserRepository.php";
include_once "./config/Database.php";

class UserService {
    private $repository;

    function __construct() {
        $this->repository = new UserRepository();
    }

    function createUser($userObject) {
        $nom = $userObject->nom;
        $role = $userObject->role;

        return $this->repository->createUser($userObject);
    }

    function getUsers() {
        return $this->repository->getUsers();
    }
}
?>