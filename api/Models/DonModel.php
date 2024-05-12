<?php

class Don {
    public $id;
    public $montant;
    public $type_don;
    public $date_don;
    public $id_donateur;
    public $commentaires;
    public $id_source;

    public function __construct($id, $montant, $type_don, $date_don, $id_donateur, $commentaires, $id_source) {
        $this->id = $id;
        $this->montant = $montant;
        $this->type_don = $type_don;
        $this->date_don = $date_don;
        $this->id_donateur = $id_donateur;
        $this->commentaires = $commentaires;
        $this->id_source = $id_source;
    }
}


?>