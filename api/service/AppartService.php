<?php
include_once "./repository/AppartRepository.php";

class AppartService {
    private $repository;

    function __construct() {
        $this->repository = new AppartRepository();
    }

    function createAppart($userObject) {
        return $this->repository->createAppart($userObject);
    }

    function getApparts() {
        return $this->repository->getApparts();
    }

    function getAppart(int $id) {
 return $this->repository->getappart($id);
    }

    function isAppartReserve(){
        return $this->repository->isAppartReserve($appartId);
    }
    
}


?>