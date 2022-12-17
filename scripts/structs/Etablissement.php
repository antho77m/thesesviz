<?php

class Etablissement {
    private string $idref;
    private string $nom;

    public function __construct(string $nom){
        $this->nom = $nom;
        $this->idref = "";
        
    }

    public function setIdRef(string $idref){
        $this->idref = $idref;
    }

    public function insertEtablissement(PDO $cnx, int $theseId){
        if($this->idref==""){
            $prep = $cnx->prepare("SELECT * FROM etablissement WHERE nom = :nom AND idref IS :idref");
        }else{
            $prep = $cnx->prepare("SELECT * FROM etablissement WHERE nom = :nom AND idref = :idref");
        }
        
        $prep->bindParam(':nom', $this->nom);
        $idref = $this->idref!=""?$this->idref:NULL;
        $prep->bindParam(':idref', $idref);
        $prep->execute();
        if($prep->rowCount() == 0){
            //echo "insertion etablissement nom: ".$this->nom." idref: ".$idref."<br>";
            $req = $cnx->prepare("INSERT INTO etablissement (nom,idref)VALUES (:nom,:idref)");
            $req -> bindParam(':nom', $this->nom);
            $req -> bindParam(':idref', $idref);
            $req->execute();
            $id = $cnx->lastInsertId();

        }
        else{
            //echo "etablissement deja present nom: ".$this->nom." idref: ".$this->idref."<br>";
            $id = $prep->fetch()['id'];//on recupere l'id de l'etablissement
        }
        $prep =$cnx->prepare("SELECT * FROM presente WHERE id_these = :theseId AND id = :id");
        $prep->bindParam(':theseId', $theseId);
        $prep->bindParam(':id', $id);
        $prep->execute();
        if($prep->rowCount() == 0){
            //echo "insertion presente theseId: ".$theseId." id: ".$id."<br>";
            $req = $cnx->prepare("INSERT INTO presente (id_these,id)VALUES (:theseId,:id)");
            $req -> bindParam(':theseId', $theseId);
            $req -> bindParam(':id', $id);
            $req->execute();
        }
        else{
            //echo "presente deja presente theseId: ".$theseId." id: ".$id."<br>";
        }
        

    }

    public function printEtablissement(){
        echo "Etablissement: <br>";
        echo "Nom: ".$this->nom."<br>";
        echo "idref: ".($this->idref?$this->idref:"NULL")."<br>";

    }

}

?>