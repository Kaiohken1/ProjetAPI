<?php
require_once './service/AppartementService.php';
require_once './model/AppartModel.php';

class AppartementController {
    private $service;

    function __construct() {
        $this->service = new AppartementService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                if (isset($req->uri[3])) { 
                    $this->getAppartement($req, $res);
                } else {
                    $this->getAppartements($req, $res);
                }
                break;

            case "POST":
                $this->createAppartement($req, $res);
                break;

            case "PATCH":
                $this->updateAppartement($req, $res);
                break;

            case "DELETE":
                $this->deleteAppartement($req, $res);
                break;

            default:
                $res->statusCode = 405;
                $res->content = ['error' => 'Méthode non autorisée'];
                break;
        }
    }

    function getAppartement($req, $res) {
       
    }

    function getAppartements($req, $res) {
        $appartements = $this->service->getAppartements();
        $res->content = $appartements;
    }

    function createAppartement($req, $res) {
        if (empty($req->body->superficie) || empty($req->body->adresse)) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Superficie et adresse requis.']);
            return;
        }
    
        $appartementObject = new Appartement();
        $appartementObject->superficie = $req->body->superficie;
        $appartementObject->adresse = $req->body->adresse;
        
    
        try {
            $newAppartement = $this->service->createAppartement($appartementObject);
            $res->status = 201; 
            $res->content = json_encode(['message' => 'Appartement créé avec succès.']);
        } catch (Exception $e) {
            $res->status = 500;
            $res->content = json_encode(['error' => 'Erreur lors de la création de l\'appartement.']);
        }
    }

    function updateAppartement($req, $res) {
    }

    function deleteAppartement($req, $res) {
    }
}
?>
