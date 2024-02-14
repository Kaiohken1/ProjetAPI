<?php
class Reservation {
    public $appartementId;
    public $dateDebut;
    public $dateFin;
    public $clientid;
    public $prix;

    public function __construct($appartementId, $dateDebut, $dateFin, $userId, $prix_total) {
        $this->appartementId = $appartementId;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->ruserId = $userId;
        $this->prix = $prix_total;
    }
}
?>