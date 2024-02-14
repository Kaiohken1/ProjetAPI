<?php
require_once './service/AppartService.php';
require_once './model/AppartModel.php';

class AppartController {
    private $service;

    function __construct() {
        $this->service = new AppartService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                if (isset($req->uri[3])) { 
                    $this->getAppart($req, $res);
                } else {
                    $this->getApparts($req, $res);
                }
                break;

            case "POST":
                $this->createAppart($req, $res);
                break;

            case "PATCH":
                $this->updateAppart($req, $res);
                break;

            case "DELETE":
                $this->deleteAppart($req, $res);
                break;

            default:
                $res->statusCode = 405;
                $res->content = ['error' => 'Méthode non autorisée'];
                break;
        }
    }

    function getAppart($req, $res) {

        $appart = $this->service->getAppart($req->uri[3]);

        $res->status = 200;
        $res->content = $appart;
       
    }

    function getApparts($req, $res) {
        $apparts = $this->service->getApparts();
        $res->content = $apparts;
    }

    function createAppart($req, $res) {
        $decodedToken = decodeToken($req->headers['Authorization']);
        
        if(!$decodedToken) {
            $res->status = 401;
            $res->content = json_encode(['error' => 'Token invalide.']);
            return;
        }
    
        if ($decodedToken->role !== 'proprietaire') {
            $res->status = 403;
            $res->content = json_encode(['error' => 'Acces non autorise']);
            return;
        }

        if (empty($req->body->superficie) || empty($req->body->adresse)) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'Superficie et adresse requis.']);
            return;
        }
    
        $appartObject = new Appart(
            $req->body->superficie,
            $req->body->personnes,
            $req->body->adresse,
            $req->body->prix,
            $decodedToken->userId
        );
    
        try {
            $newAppart = $this->service->createAppart($appartObject);
            $res->status = 201;
            $res->content = json_encode(['message' => 'Appartement créé avec succès.']);
        } catch (Exception $e) {
            $res->status = 500;
            $res->content = json_encode(['error' => 'Erreur lors de la création de l\'appartement: ' . $e->getMessage()]);
        }
    }
    

    function updateAppart($req, $res) {
    }

    function deleteAppart($req, $res) {
    }

    function getAppartPrice($id) {
        $appart = $this->service->getAppartPrice($id);
        return $appart;
    }
}
?>
