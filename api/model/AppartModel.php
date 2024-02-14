<?php
class Appart {
    public $superficie;
    public $personnes;
    public $adresse;
    public $disponibilite;
    public $prix;
    public $proprietaireid;

    public function __construct($superficie, $personnes, $adresse, $disponibilite, $prix, $proprietaireid) {
        $this->superficie = $superficie;
        $this->personnes = $personnes;
        $this->adresse = $adresse;
        $this->disponibilite = $disponibilite;
        $this->prix = $prix;
        $this->proprietaireid = $proprietaireid;
    }
}


?>