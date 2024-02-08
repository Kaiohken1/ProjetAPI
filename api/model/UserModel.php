<?php
class Utilisateur {
    public $nom;
    public $role;
    private $conn;

    public function __construct($nom, $role) {
        $this->nom = $nom;
        $this->role = $role;
    }
}
?>