<?php
require_once './service/ReservationService.php';
require_once './model/ReservationModel.php';
require_once "./common/token.php";

class ReservationController {
    private $service;

    function __construct() {
        $this->service = new ReservationService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                if (isset($req->uri[3])) {     
                    $this->getReservation($req, $res);
                } else {
                    $this->getReservations($req, $res);
                }
                break;
    
            case "POST":
                    $this->createReservation($req, $res);
                    break;

            case "DELETE":
                $this->deleteReservation($req, $res);
                break;
    
            default:
                $res->status = 405;
                $res->content = ['error' => 'Methode non autorisee'];
                break;
        }
    }    

    function getReservation($req, $res) {
        $Reservation = $this->service->getReservation($req->uri[3]);
        $res->status = 200;
        $res->content = $Reservation;
    }

    function getReservations($req, $res) {
        $Reservations = $this->service->getReservations();
        $res->status = 200;
        $res->content = $Reservations;
    }
    
    function createReservation($req, $res) {
        
        $decodedToken = decodeToken($req->headers['Authorization']);
        $userId = $decodedToken->userId;
        //$role = $decodedToken->role;
    
        if (empty($req->body->dateDebut) || empty($req->body->dateFin) || empty($req->body->prix)) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Données de reservation manquantes.']);
            return;
        }

        $dateDebut = new DateTime($req->body->dateDebut);
        $dateFin = new DateTime($req->body->dateFin);
        $interval = $dateDebut->diff($dateFin);
        $num_days = $interval->days;
    
        $prix_total = $num_days * $req->body->prix;
        $appartementId = $req->uri[3];
        $reservation = new Reservation($appartementId, $dateDebut, $dateFin, $userId, $prix_total);
    
        try {
            $newReservation = $this->service->createReservation($reservation, $appartementId);
    
            $res->status = 201;
            $res->content = json_encode(['message' => 'Réservation créée avec succès.']);
        } catch (Exception $e) {
            $res->status = 500;
            $res->content = json_encode(['error' => 'Erreur lors de la création de la réservation.']);
        }
    }
    
    function deleteReservation($req, $res) {
        if(!isset($req->uri[3])) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Aucune réservation spécifiée.']);
        }

        $this->service->deleteReservation($req->uri[3]);

        $res->status = 200;
        $res->content = json_encode(['message' => 'La suppression de la réservation c\'est deroule avec succes']);
    }
}


?>


