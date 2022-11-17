<?php

class Etablissement {
    private $idref;
    private $nom;

    public function __construct($nom){
        $this->nom = $nom;
    }

    public function setIdRef($idref){
        $this->idref = $idref;
    }

    public function insertEtablissement($cnx){

    }

    public function printEtablissement(){
        echo "Etablissement: <br>";
        echo "Nom: ".$this->nom;
        echo "idref: ".$this->idref?$this->idref:"NULL";

    }

}

?>