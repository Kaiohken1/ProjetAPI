<?php
include_once "./config/Database.php";

class AppartementRepository {
    private $conn = null;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function createAppart($appartementObject) : void {
        try {
            $query = "INSERT INTO appartements (superficie, adresse) VALUES (:superficie, :adresse)";
    
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':superficie', $appartementObject->superficie);
            $stmt->bindParam(':adresse', $appartementObject->adresse);
            
    
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de l'appartement: " . $e->getMessage());
        }
    }

    public function getApparts(): array {
        try {
            $query = "SELECT * FROM appartements"; 
    
            $stmt = $this->conn->prepare($query); 
            $stmt->execute(); 
            $appartements = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $appartements[] = $row; 
            }
    
            return $appartements;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des appartements: " . $e->getMessage());
        }
    }
}
?>
