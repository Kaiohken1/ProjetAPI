<?php
include_once "./repository/AppartRepository.php";

class AppartService {
    private $repository;

    function __construct() {
        $this->repository = new AppartRepository();
    }

    function createAppart($appartObject) {
        $appartObject->disponibilite = true;
        return $this->repository->createAppart($appartObject);
    }

    function getApparts() {
        return $this->repository->getApparts();
    }

    function getAppart($id) {
 return $this->repository->getappart($id);
    }

    function isAppartReserve(){
        return $this->repository->isAppartReserve($appartId);
    }

    function getAppartPrice($id) {
        return $this->repository->getAppartPrice($id);
    }
    
}


?>