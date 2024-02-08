<?php
include_once "./repository/UserRepository.php";

class UserService {
    private $repository;

    function __construct() {
        $this->repository = new UserRepository();
    }

    function createUser($userObject) {
        return $this->repository->createUser($userObject);
    }

    function getUsers() {
        return $this->repository->getUsers();
    }
}
?>