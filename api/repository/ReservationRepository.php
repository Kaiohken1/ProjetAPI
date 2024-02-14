<?php
include_once "./config/Database.php";
require_once "./common/exception/repositoryException.php";


class ReservationRepository {
    private $conn = null;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function createReservation($ReservationObject, $appartementId) : void {
        try {
            $query = "INSERT INTO reservation (id, appartementId, dateDebut, dateFin, clientId, prix) VALUES (:id, :appartementId, :dateDebut, :dateFin, :clientId, :prix)"; // Fix the SQL query by adding placeholders for the bind parameters

    
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $ReservationObject->id);
            $stmt->bindParam(':appartementId', $ReservationObject->appartementId);
            $stmt->bindParam(':dateDebut', $ReservationObject->dateDebut);
            $stmt->bindParam(':dateFin', $ReservationObject->dateFin);
            $stmt->bindParam(':clientId', $ReservationObject->clientId);
            $stmt->bindParam(':prix', $ReservationObject->prix);
            
    
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de la réservation: " . $e->getMessage());
        }
    }

    public function getReservations(): array {
        $query = "SELECT * FROM reservation"; 
    
        $stmt = $this->conn->prepare($query); 

        $stmt->execute();
        $Reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Reservations[] = $row; 
        }
        return $Reservations;
    }

    function getReservation($id) {
        $query = "SELECT * FROM reservation WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
    
        $stmt->execute();
        
        $Reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$Reservation) {
            throw new BddNotFoundException("Cette réservation n'existe pas");
        }
    
        return $Reservation;
    }

    public function deleteReservation($id): void {
        $query = "DELETE FROM reservation WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    
        $rows = $stmt->rowCount();
        if ($rows === 0) {
            throw new Exception("Aucune réservation trouvé avec l'ID spécifié.");
        }
    }
    
}
?>