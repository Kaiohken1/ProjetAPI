<?php
require_once './service/UserService.php';

class UserController {
    private $service;

    function __construct() {
        $this->service = new UserService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                if (isset($req->uri[3])) { 
                    $this->getUser($req, $res);
                } else {
                    $this->getUsers($req, $res);
                }
                break;

            case "POST":
                $this->createUser($req, $res);
                break;

            case "PATCH":
                $this->updateUser($req, $res);
                break;

            case "DELETE":
                $this->deleteUser($req, $res);
                break;

            default:
                $res->statusCode = 405;
                $res->content = ['error' => 'Methode non autorisee'];
                break;
        }
    }

    function getUser($req, $res) {
    }

    function getUsers($req, $res) {
        $users = $this->service->getUsers();
        $res->content = $users;
    }

    function createUser($req, $res) {
        if (empty($req->body->nom) || empty($req->body->role)) {
            $res->status = 400;
            $res->content = json_encode(['error' => 'nom et role requis.']);
            return;
        }
    
        $userObject = new Utilisateur($req->body->nom, $req->body->role);
    
        try {
            $newUser = $this->service->createUser($userObject);
            $res->statusCode = 201; 
            $res->content = json_encode(['message' => 'Utilisateur cree avec succes.']);
        } catch (Exception $e) {
            $res->statusCode = 500;
            $res->content = json_encode(['error' => 'Erreur lors de la création de l utilisateur.']);
        }
    }

    function updateUser($req, $res) {
    }

    function deleteUser($req, $res) {
    }
}

?>