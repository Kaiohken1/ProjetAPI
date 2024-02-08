<?php
include_once "./config/Database.php";

class UserRepository {
    private $conn = null;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function createUser($userObject) : void {
        try {
            $query = "INSERT INTO utilisateurs (nom, role) VALUES (:nom, :role)";
    
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':nom', $userObject->nom);
            $stmt->bindParam(':role', $userObject->role);
    
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de l'utilisateur: " . $e->getMessage());
        }
    }

    public function getUsers(): array {
        try {
            $query = "SELECT * FROM utilisateurs"; 
    
            $stmt = $this->conn->prepare($query); 
            $stmt->execute(); 
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $row; 
            }
    
            return $users;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des utilisateurs: " . $e->getMessage());
        }
    }
    
    
}


?>