<?php
class Sujet{
    private string $libelle;

    public function __construct(string $libelle){
        $this->libelle = $libelle;
    }

    public function printSujet(){
        echo "Sujets: <br>";
        echo "Libelle: ".$this->libelle;
    }

    public function insertSujet($cnx){
        //TODO
    }
}

?>