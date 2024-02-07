<?php
include_once "../config/Database.php";

class UserRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createUser($userObject) : void {
        try {
            $query = "INSERT INTO users (nom, role) VALUES (:nom, :role)";
    
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':role', $role);
    
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de l'utilisateur: " . $e->getMessage());
        }
    }
    
}


?>