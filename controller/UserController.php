<?php
require_once '../config/Database.php';
require_once '../model/Utilisateur.php';

class UtilisateurController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->model = new Utilisateur($this->db);
    }
}


?>