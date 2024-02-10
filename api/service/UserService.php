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

    function getUser($id) {
        return $this->repository->getUser($id);
    }

    function deleteUser($id) {
        return $this->repository->deleteUser($id);
    }

    function updateUser($id, $userObject) {
        return $this->repository->deleteUser($id);
    }
}
?>