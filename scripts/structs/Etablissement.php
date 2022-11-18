<?php

class Etablissement {
    private string $idref;
    private string $nom;

    public function __construct(string $nom){
        $this->nom = $nom;
    }

    public function setIdRef(string $idref){
        $this->idref = $idref;
    }

    public function insertEtablissement(PDO $cnx){
        //TODO
    }

    public function printEtablissement(){
        echo "Etablissement: <br>";
        echo "Nom: ".$this->nom."<br>";
        echo "idref: ".($this->idref?$this->idref:"NULL")."<br>";

    }

}

?>