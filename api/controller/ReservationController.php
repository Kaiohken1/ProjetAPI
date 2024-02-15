<?php
require_once './service/ReservationService.php';
require_once './model/ReservationModel.php';
require_once "./common/token.php";

class ReservationController {
    private $service;
    private $appartRepository;

    function __construct() {
        $this->service = new ReservationService();
        $this->appartRepository = new AppartRepository();
    }

    public function getAppartPrice($id) {
        return $this->appartRepository->getAppartPrice($id);
    }

    public function dispatch($req, $res) {
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
                $res->content = json_encode(['error' => 'Methode non autorisee']);
                break;
        }
    }

    private function getReservation($req, $res) {
        $reservation = $this->service->getReservation($req->uri[3]);
        
        $res->status = 200;
        $res->content = $reservation;
    }

    private function getReservations($req, $res) {
        $reservations = $this->service->getReservations();
        $res->status = 200;
        $res->content = $reservations;
    }

    private function createReservation($req, $res) {
        $decodedToken = decodeToken($req->headers['Authorization']);

        if(empty($req->body->dateDebut) || empty($req->body->dateFin)) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Les données nécessaires pour créer une réservation sont manquantes.']);
            return;
        }

        if (empty($req->uri[3])) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Aucun appartement donne']);
            return;
        }

        try {
            $prix = $this->getAppartPrice($req->uri[3]);

            $dateDebut = new DateTime($req->body->dateDebut);
            $dateFin = new DateTime($req->body->dateFin);
            $duree = $dateDebut->diff($dateFin)->days;
            $prixTotal = $prix * $duree;

            $reservationObject = new Reservation(
                $req->uri[3],
                $req->body->dateDebut,
                $req->body->dateFin,
                $decodedToken->userId,
                $prixTotal
            );

            $this->service->createReservation($reservationObject);
            $res->status = 201; 
            $res->content = json_encode(['message' => 'Reservation creee avec succes.']);
        } catch (Exception $e) {
            $res->status = 500;
            $res->content = json_encode(['error' => $e->getMessage()]);
        }
    }

    function deleteReservation($req, $res) {
        if(!isset($req->uri[3])) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Aucune réservation spécifiée.']);
            return;
        }

        $decodedToken = decodeToken($req->headers['Authorization']);

        $reservation = $this->service->getReservation($req->uri[3]);

        if(!$reservation || !isset($reservation['clientid'])) {
            $res->status = 404;
            $res->content = json_encode(['error' => 'Reservation introuvable.']);
            return;
        }

        if(!$decodedToken || $decodedToken->userId !== $reservation['clientid']) {
            $res->status = 403;
            $res->content = json_encode(['error' => 'Acces non autorise.']);
            return;
        }

        $this->service->deleteReservation($req->uri[3]);

        $res->status = 200;
        $res->content = json_encode(['message' => 'La suppression de la reservation s\'est deroule avec succes']);
    }
}
?>
