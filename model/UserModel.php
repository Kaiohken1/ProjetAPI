<?php
class Utilisateur {
    public $id;
    public $nom;
    public $role
    private $conn;

    public function connectDatabse($db) {
        $this->conn = $db
    }
}
?>