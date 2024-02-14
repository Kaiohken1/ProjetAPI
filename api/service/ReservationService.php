ReservationService.php

<?php
include_once "./repository/ReservationRepository.php";


class ReservationService {
    private $repository;

    function __construct() {
        $this->repository = new ReservationRepository();
    }

    function createReservation($ReservationObject) {
        return $this->repository->createReservation($ReservationObject);
    }

    function getReservations() {
        return $this->repository->getReservations();
    }

    function getReservation($id) {
        return $this->repository->getReservation($id);
    }

    function deleteReservation($id) {
        return $this->repository->deleteReservation($id);
    }
}
?>