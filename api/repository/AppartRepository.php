<?php
include_once "./config/Database.php";

class AppartRepository {
    private $conn = null;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function createAppart($appartObject) : void {
        try {
           
            $query = "INSERT INTO appartement (superficie, adresse, personnes, disponibilite, prix, proprietaireid) VALUES (:superficie, :adresse, :personnes, :disponibilite, :prix, :proprietaireid)";
    
            $stmt = $this->conn->prepare($query);
    
            
            $stmt->bindParam(':superficie', $appartObject->superficie);
            $stmt->bindParam(':adresse', $appartObject->adresse);
            $stmt->bindParam(':personnes', $appartObject->personnes);
            $stmt->bindParam(':disponibilite', $appartObject->disponibilite);
            $stmt->bindParam(':prix', $appartObject->prix);
            $stmt->bindParam(':proprietaireid', $appartObject->proprietaireid);
           
    
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de l'appartement: " . $e->getMessage());
        }
    }
    

    public function getApparts(): array {
        try {
            $query = "SELECT * FROM appartement"; 
    
            $stmt = $this->conn->prepare($query); 
            $stmt->execute(); 
            $apparts = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $apparts[] = $row; 
            }
    
            return $apparts;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des appartements: " . $e->getMessage());
        }
    }
    
    
    public function getAppart(int $id): ?array {
        try {
            $query = "SELECT * FROM appartement WHERE id = :id";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
          
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                return $row;
            } else {
               
                return null;
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de l'appartement: " . $e->getMessage());
        }
    }
    


    public function isAppartReserve(int $appartId): bool {
        try {
            $query = "SELECT disponibilite FROM appartement WHERE id = :id";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $appartId, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return (bool)$row['disponibilite'];
            } else {
                throw new Exception("Aucun appartement trouve avec l'ID $appartId");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification du statut de réservation de l'appartement: " . $e->getMessage());
        }
    }

    public function getAppartPrice($id): int {
        try {
            $query = "SELECT prix FROM appartement WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['prix'];
            } else {
                throw new Exception("Aucun appartement trouve avec l'ID $id");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO lors de la recuperation du prix de l'appartement: " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la recuperation du prix de l'appartement: " . $e->getMessage());
        }
    }
    
}




?>
