<?php
class Reservation {
    public $appartementId;
    public $dateDebut;
    public $dateFin;
    public $clientId;
    public $prix;

    public function __construct($appartementId, $dateDebut, $dateFin, $clientId, $prix) {
        $this->appartementId = $appartementId;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->clientId = $clientId;
        $this->prix = $prix;
    }
}
?>