<?php
class Sujets{
    private string $libelle;

    public function __construct(string $libelle){
        $this->libelle = $libelle;
    }

    public function printSujets(){
        echo "Sujets: <br>";
        echo "Libelle: ".$this->libelle;
    }

    public function insertSujets($cnx){
        //TODO
    }
}

?>